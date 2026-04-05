<?php
namespace RaicesVivas\Config;

class Parameters {
    // Al entrar a index.php sin parámetros → página principal
    public static $CONTROLLER_DEFAULT = "Index";
    public static $ACTION_DEFAULT     = "showIndex";

    // URL base — ajusta si tu carpeta en htdocs tiene otro nombre
    public static $BASE_URL = "http://localhost/raicesvivas/";

    public static function getBasePath(): string {
        return $_SERVER['DOCUMENT_ROOT'] . "/raicesvivas/";
    }
}