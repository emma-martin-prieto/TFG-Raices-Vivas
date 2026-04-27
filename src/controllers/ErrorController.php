<?php
namespace RaicesVivas\Controllers;

class ErrorController {

    public function mostrar404(): void {
        ViewController::showError(404);
    }
}