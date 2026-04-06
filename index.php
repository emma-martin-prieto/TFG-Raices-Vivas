<?php
session_name("RaicesVivas");
session_start();

require_once 'vendor/autoload.php';

use RaicesVivas\Config\Parameters;
use RaicesVivas\Controllers\ErrorController;

$nameController  = "RaicesVivas\\Controllers\\";
$nameController .= ($_GET['controller'] ?? Parameters::$CONTROLLER_DEFAULT) . "Controller";
$action          = $_GET['action'] ?? Parameters::$ACTION_DEFAULT;

if (class_exists($nameController)) {
    $controller = new $nameController();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        (new ErrorController())->mostrar404();
    }
} else {
    (new ErrorController())->mostrar404();
}
