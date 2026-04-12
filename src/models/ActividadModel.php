<?php
namespace RaicesVivas\Models;

class ActividadModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->tabla = "actividad";
    }

    /*Todas las actividades activas con su tipo y organizador.*/
    public function getAllConTipo(): array|null {
        try {
            $consulta = "SELECT a.id, a.tipo, a.nombre, a.descripcion_general,
                                a.precio, a.duracion,
                                o.nombre AS organizador,
                                t.nivel, t.materiales_incluidos,
                                r.dificultad, r.distancia_km, r.recomendaciones,
                                r.punto_inicio, r.punto_fin,
                                ch.tema,
                                al.tipo_alojamiento, al.noches, al.regimen, al.condiciones,
                                prox.fecha_hora_inicio, prox.fecha_hora_fin, prox.cupo_max,
                                (prox.cupo_max - COALESCE(prox.inscritos, 0)) AS plazas_libres
                         FROM actividad a
                         JOIN organizador      o  ON a.id_organizador = o.id
                         LEFT JOIN taller      t  ON a.id = t.id_actividad
                         LEFT JOIN ruta        r  ON a.id = r.id_actividad
                         LEFT JOIN charla      ch ON a.id = ch.id_actividad
                         LEFT JOIN alojamiento al ON a.id = al.id_actividad
                         LEFT JOIN (
                             SELECT s.id_actividad,
                                    s.fecha_hora_inicio, s.fecha_hora_fin, s.cupo_max,
                                    COUNT(ps.id_persona) AS inscritos
                             FROM sesion s
                             LEFT JOIN persona_sesion ps ON s.id = ps.id_sesion
                             WHERE s.id_edicion = 3
                               AND s.id = (
                                   SELECT id FROM sesion s2
                                   WHERE s2.id_actividad = s.id_actividad
                                     AND s2.id_edicion = 3
                                   ORDER BY s2.fecha_hora_inicio ASC
                                   LIMIT 1
                               )
                             GROUP BY s.id
                         ) prox ON a.id = prox.id_actividad
                         WHERE a.estado = 'activa'
                         ORDER BY a.tipo, a.nombre";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetchAll();

        } catch (\PDOException $e) {
            error_log("ActividadModel. getAllConTipo: " . $e->getMessage());
            return null;
        }
    }

    /*Una actividad completa con todos sus datos de subtipo. Usado en: modal de detalle*/
    public function getDetalleById(int $id): mixed {
        try {
            $consulta = "SELECT a.id, a.tipo, a.nombre, a.descripcion_general,
                                a.precio, a.duracion, a.motivo_cancelacion,
                                o.nombre AS organizador,
                                t.nivel, t.materiales_incluidos,
                                r.dificultad, r.distancia_km,
                                r.recomendaciones, r.punto_inicio, r.punto_fin,
                                ch.tema,
                                al.tipo_alojamiento, al.noches, al.regimen, al.condiciones
                         FROM actividad a
                         JOIN organizador      o  ON a.id_organizador = o.id
                         LEFT JOIN taller      t  ON a.id = t.id_actividad
                         LEFT JOIN ruta        r  ON a.id = r.id_actividad
                         LEFT JOIN charla      ch ON a.id = ch.id_actividad
                         LEFT JOIN alojamiento al ON a.id = al.id_actividad
                         WHERE a.id = :id";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':id', $id, \PDO::PARAM_INT);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetch();

        } catch (\PDOException $e) {
            error_log("ActividadModel. getDetalleById: " . $e->getMessage());
            return null;
        }
    }

    /*Actividades filtradas por tipo (taller | ruta | charla | alojamiento).*/
    public function getByTipo(string $tipo): array|null {
        try {
            $tablasValidas = ['taller', 'ruta', 'charla', 'alojamiento'];
            if (!in_array($tipo, $tablasValidas)) return null;

            $consulta = "SELECT a.id, a.tipo, a.nombre, a.descripcion_general,
                                a.precio, a.duracion,
                                o.nombre AS organizador
                         FROM actividad a
                         JOIN $tipo       sub ON a.id = sub.id_actividad
                         JOIN organizador o   ON a.id_organizador = o.id
                         WHERE a.estado = 'activa'
                         ORDER BY a.nombre";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetchAll();

        } catch (\PDOException $e) {
            error_log("ActividadModel. getByTipo ($tipo): " . $e->getMessage());
            return null;
        }
    }

    /*Sesiones de una actividad en la edición 2026 con plazas libres calculadas. Usado en: modal de detalle y formulario de inscripción.*/
    public function getSesionesByActividad(int $idActividad): array|null {
        try {
            $consulta = "SELECT s.id, s.cupo_max, s.fecha_hora_inicio, s.fecha_hora_fin,
                                (s.cupo_max - COUNT(ps.id_persona)) AS plazas_libres
                         FROM sesion s
                         JOIN edicion e            ON s.id_edicion = e.id
                         LEFT JOIN persona_sesion ps ON s.id = ps.id_sesion
                         WHERE s.id_actividad = :idActividad
                           AND e.anio = 2026
                         GROUP BY s.id
                         ORDER BY s.fecha_hora_inicio";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->bindParam(':idActividad', $idActividad, \PDO::PARAM_INT);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetchAll();

        } catch (\PDOException $e) {
            error_log("ActividadModel. getSesionesByActividad: " . $e->getMessage());
            return null;
        }
    }

    /*Cuenta las actividades activas de un tipo concreto.*/
    public function countByTipo(string $tipo): int {
        try {
            $tablasValidas = ['taller', 'ruta', 'charla', 'alojamiento'];
            if (!in_array($tipo, $tablasValidas)) return 0;

            $consulta = "SELECT COUNT(*) AS cuenta
                         FROM actividad a
                         JOIN $tipo sub ON a.id = sub.id_actividad
                         WHERE a.estado = 'activa'";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetch()->cuenta;

        } catch (\PDOException $e) {
            error_log("ActividadModel. countByTipo ($tipo): " . $e->getMessage());
            return -1;
        }
    }

    /* Devuelve el id de la primera sesión disponible (con plazas libres) de una actividad en la edición 2026.
     Si no hay sesiones con plazas, devuelve la primera sesión igualmente.*/
    public function getPrimeraSesionId(int $idActividad): int|null {
        try {
            $sql = "SELECT id
                    FROM sesion
                    WHERE id_actividad = :idActividad
                      AND id_edicion = 3
                    ORDER BY fecha_hora_inicio ASC
                    LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':idActividad', $idActividad, \PDO::PARAM_INT);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row ? (int)$row->id : null;

        } catch (\PDOException $e) {
            error_log("ActividadModel. getPrimeraSesionId: " . $e->getMessage());
            return null;
        }
    }
}