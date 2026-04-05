<?php
namespace RaicesVivas\Models;

use RaicesVivas\Database\Conexion;

class Model {
    protected $conn;
    protected $tabla;

    public function __construct() {
        $this->conn = Conexion::conectar();
    }

    public function getOne($id): mixed {
        try {
            $sql = "SELECT * FROM {$this->tabla} WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            echo '<p>Error getOne: ' . $e->getMessage() . '</p>';
            return null;
        }
    }

    public function getAll(): array|null {
        try {
            $sql  = "SELECT * FROM {$this->tabla}";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            echo '<p>Error getAll: ' . $e->getMessage() . '</p>';
            return null;
        }
    }

    public function count(): int {
        try {
            $sql  = "SELECT COUNT(*) AS cuenta FROM {$this->tabla}";
            $stmt = $this->conn->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt->fetch()->cuenta;
        } catch (\PDOException $e) {
            return -1;
        }
    }
}