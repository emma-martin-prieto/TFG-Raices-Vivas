<?php
namespace RaicesVivas\Database;

use RaicesVivas\Config\ConfigBD;

class Conexion {
    public static function conectar(): ?\PDO {
        try {
            $dsn = 'mysql:host=' . ConfigBD::$SERVER_NAME_BD
                 . ';dbname='   . ConfigBD::$DB_NAME
                 . ';port='     . ConfigBD::$SERVER_PORT_BD
                 . ';charset='  . ConfigBD::$CHARSET;

            $conn = new \PDO($dsn, ConfigBD::$USER_BD, ConfigBD::$PASSWORD_BD);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $conn;

        } catch (\PDOException $e) {
            echo '<p>Error de conexión: ' . $e->getMessage() . '</p>';
            return null;
        }
    }
}
