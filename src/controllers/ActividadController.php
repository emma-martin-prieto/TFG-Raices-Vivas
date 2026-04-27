<?php
namespace RaicesVivas\Controllers;

use RaicesVivas\Models\ActividadModel;

class ActividadController {

    /*Muestra la página de experiencias con todas las actividades de la BD.*/
    public function showExperiencias(): void {
        $model       = new ActividadModel();
        $actividades = $model->getAllConTipo();

        ViewController::show('views/actividades/showAll.php', [
            'actividades' => $actividades
        ]);
    }
}