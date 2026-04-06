<?php
namespace RaicesVivas\Config;

class Parameters {
    public static $CONTROLLER_DEFAULT = "Index";
    public static $ACTION_DEFAULT     = "showIndex";
    public static $BASE_URL = "http://localhost/raicesvivas/";

    public static function getBasePath(): string {
        return $_SERVER['DOCUMENT_ROOT'] . "/raicesvivas/";
    }
}