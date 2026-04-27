<?php
namespace RaicesVivas\Models;

class AdminActividadModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->tabla = 'actividad';
    }

    /* Todas las actividades con organizador. */
    public function getAllAdmin(): array|null {
        try {
            $sql = "SELECT a.id, a.nombre, a.tipo, a.precio, a.duracion, a.estado,
                           o.nombre AS organizador,
                           (SELECT COUNT(*) FROM sesion s WHERE s.id_actividad = a.id) AS num_sesiones,
                           (SELECT SUM(s.cupo_max) FROM sesion s WHERE s.id_actividad = a.id) AS cupo_total
                    FROM actividad a
                    JOIN organizador o ON a.id_organizador = o.id
                    ORDER BY a.tipo, a.nombre";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.getAllAdmin: " . $e->getMessage());
            return null;
        }
    }

    /* Actividad completa con datos de subtipo. */
    public function getDetalleAdmin(int $id): mixed {
        try {
            $sql = "SELECT a.id, a.nombre, a.tipo, a.descripcion_general,
                           a.precio, a.duracion, a.estado, a.motivo_cancelacion,
                           a.id_organizador,
                           t.nivel, t.materiales_incluidos,
                           r.dificultad, r.distancia_km, r.recomendaciones,
                           r.punto_inicio, r.punto_fin,
                           ch.tema,
                           al.tipo_alojamiento, al.noches, al.regimen, al.condiciones
                    FROM actividad a
                    LEFT JOIN taller      t  ON a.id = t.id_actividad
                    LEFT JOIN ruta        r  ON a.id = r.id_actividad
                    LEFT JOIN charla      ch ON a.id = ch.id_actividad
                    LEFT JOIN alojamiento al ON a.id = al.id_actividad
                    WHERE a.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.getDetalleAdmin: " . $e->getMessage());
            return null;
        }
    }

    /* Sesiones de una actividad con plazas libres. */
    public function getSesionesAdmin(int $idActividad): array|null {
        try {
            $sql = "SELECT s.id, s.cupo_max, s.fecha_hora_inicio, s.fecha_hora_fin,
                           (s.cupo_max - COUNT(ps.id_persona)) AS plazas_libres,
                           COUNT(ps.id_persona) AS inscritos
                    FROM sesion s
                    LEFT JOIN persona_sesion ps ON s.id = ps.id_sesion
                    WHERE s.id_actividad = :id
                    GROUP BY s.id
                    ORDER BY s.fecha_hora_inicio";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $idActividad, \PDO::PARAM_INT);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.getSesionesAdmin: " . $e->getMessage());
            return null;
        }
    }

    /* Inserta una sesión y devuelve su id. */
    public function insertarSesion(int $idActividad, string $inicio, string $fin, int $cupo): int|null {
        try {
            // Obtener id_edicion actual (año 2026)
            $stmtEd = $this->conn->prepare("SELECT id FROM edicion WHERE anio = 2026 LIMIT 1");
            $stmtEd->execute();
            $edicion = $stmtEd->fetchColumn();
            if (!$edicion) return null;

            $sql = "INSERT INTO sesion (cupo_max, fecha_hora_inicio, fecha_hora_fin, id_actividad, id_edicion)
                    VALUES (:cupo, :inicio, :fin, :id_act, :id_ed)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':cupo'   => $cupo,
                ':inicio' => $inicio,
                ':fin'    => $fin,
                ':id_act' => $idActividad,
                ':id_ed'  => $edicion,
            ]);
            return (int)$this->conn->lastInsertId();
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.insertarSesion: " . $e->getMessage());
            return null;
        }
    }

    /* Actualiza una sesión existente. */
    public function actualizarSesion(int $idSesion, string $inicio, string $fin, int $cupo): bool {
        try {
            $sql = "UPDATE sesion SET cupo_max = :cupo, fecha_hora_inicio = :inicio, fecha_hora_fin = :fin
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':cupo' => $cupo, ':inicio' => $inicio, ':fin' => $fin, ':id' => $idSesion]);
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.actualizarSesion: " . $e->getMessage());
            return false;
        }
    }

    /* Elimina las sesiones de una actividad que NO estén en la lista de ids conservados. */
    public function eliminarSesionesExcepto(int $idActividad, array $idsConservar): bool {
        try {
            if (empty($idsConservar)) {
                $stmt = $this->conn->prepare("DELETE FROM sesion WHERE id_actividad = :id");
                $stmt->execute([':id' => $idActividad]);
            } else {
                $placeholders = implode(',', array_fill(0, count($idsConservar), '?'));
                $sql  = "DELETE FROM sesion WHERE id_actividad = ? AND id NOT IN ($placeholders)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute(array_merge([$idActividad], $idsConservar));
            }
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.eliminarSesionesExcepto: " . $e->getMessage());
            return false;
        }
    }

    /* Inserta nueva actividad y devuelve el id generado. */
    public function insertarActividad(array $datos): int|null {
        try {
            $sql = "INSERT INTO actividad
                        (nombre, tipo, descripcion_general, precio, duracion, estado, id_organizador)
                    VALUES
                        (:nombre, :tipo, :descripcion_general, :precio, :duracion, :estado, :id_organizador)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre'              => $datos['nombre'],
                ':tipo'                => $datos['tipo'],
                ':descripcion_general' => $datos['descripcion_general'],
                ':precio'              => $datos['precio'],
                ':duracion'            => $datos['duracion'],
                ':estado'              => $datos['estado'],
                ':id_organizador'      => $datos['id_organizador'],
            ]);
            return (int)$this->conn->lastInsertId();
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.insertarActividad: " . $e->getMessage());
            return null;
        }
    }

    /* Inserta la fila de subtipo. */
    public function insertarSubtipo(int $idActividad, string $tipo, array $datos): bool {
        try {
            $sql = match($tipo) {
                'taller' =>
                    "INSERT INTO taller (id_actividad, nivel, materiales_incluidos)
                     VALUES (:id, :nivel, :materiales_incluidos)",
                'ruta' =>
                    "INSERT INTO ruta (id_actividad, dificultad, distancia_km, recomendaciones, punto_inicio, punto_fin)
                     VALUES (:id, :dificultad, :distancia_km, :recomendaciones, :punto_inicio, :punto_fin)",
                'charla' =>
                    "INSERT INTO charla (id_actividad, tema) VALUES (:id, :tema)",
                'alojamiento' =>
                    "INSERT INTO alojamiento (id_actividad, tipo_alojamiento, noches, regimen, condiciones)
                     VALUES (:id, :tipo_alojamiento, :noches, :regimen, :condiciones)",
                default => null
            };
            if (!$sql) return false;
            $params = array_merge([':id' => $idActividad], array_combine(
                array_map(fn($k) => ":$k", array_keys($datos)),
                array_values($datos)
            ));
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.insertarSubtipo: " . $e->getMessage());
            return false;
        }
    }

    /* Actualiza campos principales de actividad. */
    public function actualizarActividad(int $id, array $datos): bool {
        try {
            $sql = "UPDATE actividad
                    SET nombre              = :nombre,
                        tipo                = :tipo,
                        descripcion_general = :descripcion_general,
                        precio              = :precio,
                        duracion            = :duracion,
                        estado              = :estado,
                        motivo_cancelacion  = :motivo_cancelacion,
                        id_organizador      = :id_organizador
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nombre'              => $datos['nombre'],
                ':tipo'                => $datos['tipo'],
                ':descripcion_general' => $datos['descripcion_general'],
                ':precio'              => $datos['precio'],
                ':duracion'            => $datos['duracion'],
                ':estado'              => $datos['estado'],
                ':motivo_cancelacion'  => $datos['motivo_cancelacion'] ?? null,
                ':id_organizador'      => $datos['id_organizador'],
                ':id'                  => $id,
            ]);
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.actualizarActividad: " . $e->getMessage());
            return false;
        }
    }

    /* Actualiza o inserta los datos del subtipo. */
    public function actualizarSubtipo(int $idActividad, string $tipo, array $datos): bool {
        try {
            $sql = match($tipo) {
                'taller' =>
                    "INSERT INTO taller (id_actividad, nivel, materiales_incluidos)
                     VALUES (:id, :nivel, :materiales_incluidos)
                     ON DUPLICATE KEY UPDATE
                        nivel                = VALUES(nivel),
                        materiales_incluidos = VALUES(materiales_incluidos)",
                'ruta' =>
                    "INSERT INTO ruta (id_actividad, dificultad, distancia_km, recomendaciones, punto_inicio, punto_fin)
                     VALUES (:id, :dificultad, :distancia_km, :recomendaciones, :punto_inicio, :punto_fin)
                     ON DUPLICATE KEY UPDATE
                        dificultad      = VALUES(dificultad),
                        distancia_km    = VALUES(distancia_km),
                        recomendaciones = VALUES(recomendaciones),
                        punto_inicio    = VALUES(punto_inicio),
                        punto_fin       = VALUES(punto_fin)",
                'charla' =>
                    "INSERT INTO charla (id_actividad, tema) VALUES (:id, :tema)
                     ON DUPLICATE KEY UPDATE tema = VALUES(tema)",
                'alojamiento' =>
                    "INSERT INTO alojamiento (id_actividad, tipo_alojamiento, noches, regimen, condiciones)
                     VALUES (:id, :tipo_alojamiento, :noches, :regimen, :condiciones)
                     ON DUPLICATE KEY UPDATE
                        tipo_alojamiento = VALUES(tipo_alojamiento),
                        noches           = VALUES(noches),
                        regimen          = VALUES(regimen),
                        condiciones      = VALUES(condiciones)",
                default => null
            };
            if (!$sql) return false;
            $params = array_merge([':id' => $idActividad], array_combine(
                array_map(fn($k) => ":$k", array_keys($datos)),
                array_values($datos)
            ));
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.actualizarSubtipo: " . $e->getMessage());
            return false;
        }
    }

    /* Elimina una actividad y sus subtipos. */
    public function eliminarActividad(int $id): bool {
        try {
            foreach (['taller','ruta','charla','alojamiento'] as $tabla) {
                $stmt = $this->conn->prepare("DELETE FROM $tabla WHERE id_actividad = :id");
                $stmt->execute([':id' => $id]);
            }
            // Borrar sesiones y sus inscripciones
            $stmt = $this->conn->prepare("SELECT id FROM sesion WHERE id_actividad = :id");
            $stmt->execute([':id' => $id]);
            $ids = $stmt->fetchAll(\PDO::FETCH_COLUMN);
            foreach ($ids as $sesId) {
                $stmt2 = $this->conn->prepare("DELETE FROM persona_sesion WHERE id_sesion = :sid");
                $stmt2->execute([':sid' => $sesId]);
            }
            $stmt = $this->conn->prepare("DELETE FROM sesion WHERE id_actividad = :id");
            $stmt->execute([':id' => $id]);

            $stmt = $this->conn->prepare("DELETE FROM actividad WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return true;
        } catch (\PDOException $e) {
            error_log("AdminActividadModel.eliminarActividad: " . $e->getMessage());
            return false;
        }
    }
}