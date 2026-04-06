<?php
namespace RaicesVivas\Controllers;

use RaicesVivas\Models\ActividadModel;

class CarritoController {

    /*Añade una actividad al carrito (guardado en sesión). Devuelve JSON para que el JS muestre el toast.*/
    public function aniadir(): void {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id <= 0) {
            echo json_encode(['ok' => false, 'mensaje' => 'Actividad no válida']);
            exit();
        }

        // Inicializar carrito si no existe
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }

        // Comprobar si ya está añadida
        if (in_array($id, $_SESSION['carrito'])) {
            echo json_encode(['ok' => false, 'mensaje' => '¡Ya tienes esta actividad en tu selección!']);
            exit();
        }

        // Añadir al carrito
        $_SESSION['carrito'][] = $id;

        echo json_encode([
            'ok'      => true,
            'mensaje' => '¡Añadido a tu selección!',
            'total'   => count($_SESSION['carrito'])
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

        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? 'index.php?controller=Inscripcion&action=showFormulario');
        exit();
    }

    /*Vacía el carrito entero.*/
    public function vaciar(): void {
        unset($_SESSION['carrito']);
        header('Location: index.php?controller=Actividad&action=showExperiencias');
        exit();
    }
}