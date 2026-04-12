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

    /*Devuelve las plazas libres de todas las actividades en JSON. Usado para actualizar las tarjetas sin recargar.*/
    public function getPlazasLibres(): void {
        header('Content-Type: application/json; charset=utf-8');
        $model       = new ActividadModel();
        $actividades = $model->getAllConTipo();

        $plazas = [];
        if ($actividades) {
            foreach ($actividades as $act) {
                $plazas[$act->id] = [
                    'cupo_max'      => (int)$act->cupo_max,
                    'plazas_libres' => max(0, (int)$act->plazas_libres)
                ];
            }
        }
        echo json_encode($plazas);
        exit();
    }

    /*Devuelve el detalle de una actividad (para el modal).*/
    public function getDetalle(): void {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($id) {
            $model      = new ActividadModel();
            $actividad  = $model->getDetalleById($id);
            $sesiones   = $model->getSesionesByActividad($id);

            ViewController::show('views/actividades/showDetalle.php', [
                'actividad' => $actividad,
                'sesiones'  => $sesiones
            ]);
        } else {
            ViewController::showError(404);
        }
    }
}