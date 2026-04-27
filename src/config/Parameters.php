<?php
namespace RaicesVivas\Config;

class Parameters {
    public static $CONTROLLER_DEFAULT = "Index";
    public static $ACTION_DEFAULT     = "showIndex";
    public static $BASE_URL = "http://localhost/raicesvivas/";

    public static function getBasePath(): string {
        return $_SERVER['DOCUMENT_ROOT'] . "/raicesvivas/";
    }

    /**
     * Genera una URL limpia: Controller/action[/extra]
     * Ejemplo: Parameters::url('Admin', 'showPanel') → "http://localhost/raicesvivas/Admin/showPanel"
     */
    public static function url(string $controller, string $action, string $extra = ''): string {
        $url = self::$BASE_URL . $controller . '/' . $action;
        if ($extra !== '') $url .= '/' . $extra;
        return $url;
    }
}