<?php
session_name("RaicesVivas");
session_start();

require_once 'vendor/autoload.php';

use RaicesVivas\Config\Parameters;
use RaicesVivas\Controllers\ErrorController;

// ── CONTROLADOR FRONTAL ──────────────────────────────────────────────────────
// Las URLs tienen esta forma:
//   index.php?controller=Actividad&action=showExperiencias
//   index.php?controller=Actividad&action=getDetalle&id=3
// Si no llega nada usa los valores por defecto de Parameters.
// ─────────────────────────────────────────────────────────────────────────────

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
