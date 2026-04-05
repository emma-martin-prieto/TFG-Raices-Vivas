<?php
namespace RaicesVivas\Controllers;

class ErrorController {

    public function mostrar404(): void {
        ViewController::showError(404);
    }

    public function mostrar403(): void {
        ViewController::showError(403);
    }
}
