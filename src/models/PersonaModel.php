<?php
namespace RaicesVivas\Models;

use RaicesVivas\Entities\PersonaEntity;

class PersonaModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->tabla = "persona";
    }

    /*Inserta una persona nueva en la BD*/
    public function create(PersonaEntity $persona): bool {
        try {
            $consulta = "INSERT INTO persona (codigo, nombre, priApe, segApe, fecha_nacimiento, email, rol, id_localidad)
                         VALUES (:codigo, :nombre, :priApe, :segApe, :fechaNacimiento, :email, 'USER', :idLocalidad)";

            $sentencia = $this->conn->prepare($consulta);

            $codigo          = $persona->getCodigo();
            $nombre          = $persona->getNombre();
            $priApe          = $persona->getPriApe();
            $segApe          = $persona->getSegApe();
            $fechaNacimiento = $persona->getFechaNacimiento();
            $email           = $persona->getEmail();
            $idLocalidad     = $persona->getIdLocalidad();

            $sentencia->bindParam(':codigo',          $codigo);
            $sentencia->bindParam(':nombre',          $nombre);
            $sentencia->bindParam(':priApe',          $priApe);
            $sentencia->bindParam(':segApe',          $segApe);
            $sentencia->bindParam(':fechaNacimiento', $fechaNacimiento);
            $sentencia->bindParam(':email',           $email);
            $sentencia->bindParam(':idLocalidad',     $idLocalidad);

            return $sentencia->execute();

        } catch (\PDOException $e) {
            error_log("PersonaModel. create: " . $e->getMessage());
            return false;
        }
    }

    /*Devuelve el id de una persona dado su código*/
    public function getIdByCodigo(string $codigo): int|null {
        try {
            $sql  = "SELECT id FROM persona WHERE codigo = :codigo";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row ? (int)$row->id : null;
        } catch (\PDOException $e) {
            error_log("PersonaModel. getIdByCodigo: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Inserta una fila en persona_sesion (persona ↔ sesión).
     */
    public function inscribirEnSesion(int $idPersona, int $idSesion): bool {
        try {
            $sql  = "INSERT IGNORE INTO persona_sesion (id_persona, id_sesion) VALUES (:idPersona, :idSesion)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idPersona', $idPersona, \PDO::PARAM_INT);
            $stmt->bindParam(':idSesion',  $idSesion,  \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            error_log("PersonaModel. inscribirEnSesion: " . $e->getMessage());
            return false;
        }
    }

    /*Comprueba si ya existe una persona con ese email*/
    public function existeEmail(string $email): bool {
        try {
            $consulta  = "SELECT COUNT(*) AS cuenta FROM persona WHERE email = :email";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':email', $email);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetch()->cuenta > 0;

        } catch (\PDOException $e) {
            error_log("PersonaModel. existeEmail: " . $e->getMessage());
            return false;
        }
    }

    /*Comprueba si ya existe una persona con ese código RV.*/
    public function existeCodigo(string $codigo): bool {
        try {
            $consulta  = "SELECT COUNT(*) AS cuenta FROM persona WHERE codigo = :codigo";
            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':codigo', $codigo);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetch()->cuenta > 0;

        } catch (\PDOException $e) {
            error_log("PersonaModel. existeCodigo: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca una persona por su código RV y devuelve sus datos
     * junto con las actividades que tiene reservadas (via persona_sesion).
     * Devuelve un array listo para json_encode, o null si no existe.
     */
    public function getByCodigoConActividades(string $codigo): array|null {
        try {
            // 1. Buscar la persona
            $sql = "SELECT p.id, p.codigo, p.nombre, p.priApe, p.segApe,
                           p.email, p.fecha_nacimiento,
                           DATE_FORMAT(p.fecha_registro, '%d/%m/%Y') AS fecha_registro,
                           l.nombre AS localidad
                    FROM persona p
                    LEFT JOIN localidad l ON p.id_localidad = l.id
                    WHERE p.codigo = :codigo";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            $persona = $stmt->fetch();

            if (!$persona) return null;

            // 2. Buscar sus actividades via persona_sesion
            $sql2 = "SELECT a.id, a.nombre, a.precio, a.tipo,
                            s.fecha_hora_inicio
                     FROM persona_sesion ps
                     JOIN sesion    s ON ps.id_sesion    = s.id
                     JOIN actividad a ON s.id_actividad  = a.id
                     WHERE ps.id_persona = :idPersona
                     ORDER BY s.fecha_hora_inicio";

            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->bindParam(':idPersona', $persona->id, \PDO::PARAM_INT);
            $stmt2->setFetchMode(\PDO::FETCH_OBJ);
            $stmt2->execute();
            $actividades = $stmt2->fetchAll();

            return [
                'codigo'          => $persona->codigo,
                'nombre'          => $persona->nombre,
                'priApe'          => $persona->priApe,
                'segApe'          => $persona->segApe ?? '',
                'email'           => $persona->email,
                'fecha_nacimiento'=> $persona->fecha_nacimiento,
                'fecha_registro'  => $persona->fecha_registro,
                'localidad'       => $persona->localidad,
                'actividades'     => array_map(fn($a) => [
                    'id'                => $a->id,
                    'nombre'            => $a->nombre,
                    'precio'            => $a->precio,
                    'tipo'              => $a->tipo,
                    'fecha_hora_inicio' => $a->fecha_hora_inicio,
                ], $actividades)
            ];

        } catch (\PDOException $e) {
            error_log("PersonaModel. getByCodigoConActividades: " . $e->getMessage());
            return null;
        }
    }
}