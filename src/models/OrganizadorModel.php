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
}