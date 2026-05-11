<?php
namespace RaicesVivas\Models;

class OrganizadorModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->tabla = 'organizador';
    }

    /* Devuelve todos los organizadores ordenados por nombre. */
    public function getAll(): array|null {
        try {
            $sql  = "SELECT id, nombre, tipo FROM organizador ORDER BY nombre";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            error_log("OrganizadorModel.getAll: " . $e->getMessage());
            return null;
        }
    }

    public function create(string $nombre, string $tipo): bool {
        try {
            $sql  = "INSERT INTO organizador (nombre, tipo) VALUES (:nombre, :tipo)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':nombre' => $nombre, ':tipo' => $tipo]);
        } catch (\PDOException $e) {
            error_log("OrganizadorModel.create: " . $e->getMessage());
            return false;
        }
    }

    public function update(int $id, string $nombre, string $tipo): bool {
        try {
            $sql  = "UPDATE organizador SET nombre = :nombre, tipo = :tipo WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':nombre' => $nombre, ':tipo' => $tipo, ':id' => $id]);
        } catch (\PDOException $e) {
            error_log("OrganizadorModel.update: " . $e->getMessage());
            return false;
        }
    }

    /* Devuelve false si tiene actividades asociadas, true si se eliminó. */
    public function delete(int $id): bool|string {
        try {
            $check = $this->conn->prepare("SELECT COUNT(*) FROM actividad WHERE id_organizador = :id");
            $check->execute([':id' => $id]);
            if ((int)$check->fetchColumn() > 0) return 'tiene_actividades';

            $stmt = $this->conn->prepare("DELETE FROM organizador WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } catch (\PDOException $e) {
            error_log("OrganizadorModel.delete: " . $e->getMessage());
            return false;
        }
    }
}