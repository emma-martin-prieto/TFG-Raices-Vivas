<?php
namespace RaicesVivas\Controllers;

use RaicesVivas\Config\Parameters;
use RaicesVivas\Models\ActividadModel;

class CarritoController {

    /*Añade una sesión al carrito (guardado en sesión PHP). Devuelve JSON para que el JS muestre el toast.*/
    public function aniadir(): void {
        $idSesion = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($idSesion <= 0) {
            echo json_encode(['ok' => false, 'mensaje' => 'Sesión no válida']);
            exit();
        }

        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Comprobar si esta sesión ya está añadida
        if (in_array($idSesion, $_SESSION['carrito'])) {
            echo json_encode(['ok' => false, 'mensaje' => '¡Ya tienes esta sesión en tu selección!']);
            exit();
        }

        // Añadir la sesión al carrito
        $_SESSION['carrito'][] = $idSesion;

        // Obtener plazas actualizadas de esa sesión concreta
        $actividadModel = new ActividadModel();
        $sesion = $actividadModel->getSesionById($idSesion);
        $plazasLibres = $sesion ? max(0, (int)$sesion->plazas_libres) : null;
        $cupoMax      = $sesion ? (int)$sesion->cupo_max : null;

        echo json_encode([
            'ok'            => true,
            'mensaje'       => '¡Añadido a tu selección!',
            'total'         => count($_SESSION['carrito']),
            'id_sesion'     => $idSesion,
            'plazas_libres' => $plazasLibres,
            'cupo_max'      => $cupoMax
        ]);
        exit();
    }

    /*Elimina una actividad del carrito*/
    public function eliminar(): void {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if (isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array_values(
                array_filter($_SESSION['carrito'], fn($i) => $i !== $id)
            );
        }

        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'Inscripcion/showFormulario');
        exit();
    }

    /*Vacía el carrito entero.*/
    public function vaciar(): void {
        unset($_SESSION['carrito']);
        header('Location: ' . Parameters::$BASE_URL . 'Actividad/showExperiencias');
        exit();
    }
}