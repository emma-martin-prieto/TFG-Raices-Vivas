<?php
namespace RaicesVivas\Models;

class LocalidadModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->tabla = "localidad";
    }

    public function getAll(): array|null {
        try {
            $consulta = "SELECT id, nombre FROM localidad ORDER BY nombre";

            $sentencia = $this->conn->prepare($consulta);
            $sentencia->setFetchMode(\PDO::FETCH_OBJ);
            $sentencia->execute();
            return $sentencia->fetchAll();

        } catch (\PDOException $e) {
            error_log("LocalidadModel. getAll: " . $e->getMessage());
            return null;
        }
    }
}