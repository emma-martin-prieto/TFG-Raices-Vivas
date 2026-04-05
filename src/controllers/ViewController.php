<?php
namespace RaicesVivas\Controllers;

class ViewController {

    /**
     * Carga una vista pasándole variables.
     * $datos: array asociativo ['nombreVar' => $valor]
     */
    public static function show(string $vista, array $datos = []): void {
        // Extrae el array como variables locales disponibles en la vista
        extract($datos);
        require_once $vista;
    }

    /**
     * Muestra una vista de error según el código HTTP.
     */
    public static function showError(int $codigo): void {
        http_response_code($codigo);
        require_once "views/errors/{$codigo}.php";
    }
}
