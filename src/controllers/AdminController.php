<?php
namespace RaicesVivas\Controllers;

use RaicesVivas\Config\Parameters;
use RaicesVivas\Models\AdminActividadModel;
use RaicesVivas\Models\OrganizadorModel;
use RaicesVivas\Models\PersonaModel;

class AdminController {

    /* Muestra la página de login de administrador. */
    public function showLogin(): void {
        ViewController::show('views/admin/login.php', []);
    }

    /* Comprueba el código contra la BD (persona con rol ADMIN). */
    public function verificarCodigo(): void {
        $codigo = strtoupper(trim($_POST['codigo'] ?? $_GET['codigo'] ?? ''));

        $personaModel = new PersonaModel();
        $resultado = $personaModel->getByCodigoConActividades($codigo);

        if ($resultado && ($resultado['rol'] ?? '') === 'ADMIN') {
            $_SESSION['admin'] = true;
            header('Location: ' . Parameters::$BASE_URL . 'Admin/showPanel');
            exit();
        }

        // Código incorrecto: si viene de AJAX devolver JSON, si es form normal volver al login
        $esAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) ||
                  (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json'));

        if ($esAjax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Código no válido o no encontrado.', 'codigo_buscado' => $codigo]);
        } else {
            $_SESSION['admin_login_error'] = 'Código incorrecto. Inténtalo de nuevo.';
            header('Location: ' . Parameters::$BASE_URL . 'Admin/showLogin');
        }
        exit();
    }

    /* Muestra el panel de administrador. */
    public function showPanel(): void {
        $this->requireAdmin();
        $model         = new AdminActividadModel();
        $actividades   = $model->getAllAdmin();
        $organizadores = (new OrganizadorModel())->getAll();
        ViewController::show('views/admin/panel.php', [
            'actividades'   => $actividades,
            'organizadores' => $organizadores,
        ]);
    }

    /* Muestra el formulario de nueva actividad. */
    public function showCrear(): void {
        $this->requireAdmin();
        $organizadores = (new OrganizadorModel())->getAll();
        ViewController::show('views/admin/formActividad.php', [
            'actividad'     => null,
            'sesiones'      => [],
            'organizadores' => $organizadores,
            'errores'       => [],
            'modo'          => 'crear',
        ]);
    }

    /* Muestra el formulario de edición de una actividad existente. */
    public function showEditar(): void {
        $this->requireAdmin();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if (!$id) { $this->redirectPanel(); return; }

        $model     = new AdminActividadModel();
        $actividad = $model->getDetalleAdmin($id);
        if (!$actividad) { $this->redirectPanel(); return; }

        $sesiones      = $model->getSesionesAdmin($id);
        $organizadores = (new OrganizadorModel())->getAll();

        ViewController::show('views/admin/formActividad.php', [
            'actividad'     => $actividad,
            'sesiones'      => $sesiones ?? [],
            'organizadores' => $organizadores,
            'errores'       => [],
            'modo'          => 'editar',
        ]);
    }

    /* Procesa la creación de una nueva actividad. */
    public function crear(): void {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirectPanel(); return; }

        $errores = $this->validarPost();
        if (!empty($errores)) {
            $organizadores = (new OrganizadorModel())->getAll();
            ViewController::show('views/admin/formActividad.php', [
                'actividad'     => (object)$_POST,
                'sesiones'      => [],
                'organizadores' => $organizadores,
                'errores'       => $errores,
                'modo'          => 'crear',
            ]);
            return;
        }

        $model = new AdminActividadModel();
        $id    = $model->insertarActividad($this->datosPost());

        if ($id) {
            $this->insertarSubtipo($model, $id, $_POST['tipo']);
            $this->guardarSesiones($model, $id);
            $_SESSION['admin_msg'] = 'Actividad creada correctamente.';
        } else {
            $_SESSION['admin_error'] = 'Error al crear la actividad.';
        }

        $this->redirectPanel();
    }

    /* Procesa la actualización de una actividad. */
    public function editar(): void {
        $this->requireAdmin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { $this->redirectPanel(); return; }

        $id = (int)($_POST['id'] ?? 0);
        if (!$id) { $this->redirectPanel(); return; }

        $errores = $this->validarPost();
        if (!empty($errores)) {
            $model     = new AdminActividadModel();
            $actividad = $model->getDetalleAdmin($id);
            foreach ($_POST as $k => $v) { $actividad->$k = $v; }
            $sesiones      = $model->getSesionesAdmin($id);
            $organizadores = (new OrganizadorModel())->getAll();
            ViewController::show('views/admin/formActividad.php', [
                'actividad'     => $actividad,
                'sesiones'      => $sesiones ?? [],
                'organizadores' => $organizadores,
                'errores'       => $errores,
                'modo'          => 'editar',
            ]);
            return;
        }

        $model = new AdminActividadModel();
        $datos = $this->datosPost();
        if ($datos['estado'] === 'cancelada') {
            $datos['motivo_cancelacion'] = trim($_POST['motivo_cancelacion'] ?? '');
        } else {
            $datos['motivo_cancelacion'] = null;
        }

        $ok = $model->actualizarActividad($id, $datos);
        if ($ok) {
            $model->actualizarSubtipo($id, $_POST['tipo'], $this->datosSubtipoPost($_POST['tipo']));
            $this->guardarSesiones($model, $id);
            $_SESSION['admin_msg'] = 'Actividad actualizada correctamente.';
        } else {
            $_SESSION['admin_error'] = 'Error al actualizar la actividad.';
        }

        $this->redirectPanel();
    }

    /* Elimina una actividad. */
    public function eliminar(): void {
        $this->requireAdmin();
        $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
        if (!$id) { $this->redirectPanel(); return; }

        $model = new AdminActividadModel();
        $ok    = $model->eliminarActividad($id);
        $_SESSION[$ok ? 'admin_msg' : 'admin_error'] = $ok ? 'Actividad eliminada.' : 'Error al eliminar la actividad.';
        $this->redirectPanel();
    }

    /* Cierra la sesión de administrador. */
    public function logout(): void {
        unset($_SESSION['admin']);
        header('Location: ' . Parameters::$BASE_URL);
        exit();
    }

    public function crearOrganizador(): void {
        $this->requireAdmin();
        $nombre = trim($_POST['nombre'] ?? '');
        $tipo   = $_POST['tipo'] ?? '';
        $tipos  = ['empresa', 'asociacion', 'ayuntamiento', 'autonomo'];

        if (strlen($nombre) < 3 || !in_array($tipo, $tipos)) {
            $_SESSION['admin_error'] = 'Datos del organizador no válidos.';
        } else {
            $ok = (new OrganizadorModel())->create($nombre, $tipo);
            $_SESSION[$ok ? 'admin_msg' : 'admin_error'] = $ok
                ? 'Organizador creado correctamente.'
                : 'Error al crear el organizador.';
        }
        $this->redirectPanel();
    }

    public function editarOrganizador(): void {
        $this->requireAdmin();
        $id     = (int)($_POST['id'] ?? 0);
        $nombre = trim($_POST['nombre'] ?? '');
        $tipo   = $_POST['tipo'] ?? '';
        $tipos  = ['empresa', 'asociacion', 'ayuntamiento', 'autonomo'];

        if ($id <= 0 || strlen($nombre) < 3 || !in_array($tipo, $tipos)) {
            $_SESSION['admin_error'] = 'Datos del organizador no válidos.';
        } else {
            $ok = (new OrganizadorModel())->update($id, $nombre, $tipo);
            $_SESSION[$ok ? 'admin_msg' : 'admin_error'] = $ok
                ? 'Organizador actualizado correctamente.'
                : 'Error al actualizar el organizador.';
        }
        $this->redirectPanel();
    }

    public function eliminarOrganizador(): void {
        $this->requireAdmin();
        $id = (int)($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['admin_error'] = 'ID no válido.';
        } else {
            $resultado = (new OrganizadorModel())->delete($id);
            if ($resultado === 'tiene_actividades') {
                $_SESSION['admin_error'] = 'No se puede eliminar: el organizador tiene actividades asociadas.';
            } else {
                $_SESSION[$resultado ? 'admin_msg' : 'admin_error'] = $resultado
                    ? 'Organizador eliminado correctamente.'
                    : 'Error al eliminar el organizador.';
            }
        }
        $this->redirectPanel();
    }

    // ── Helpers privados

    private function requireAdmin(): void {
        if (empty($_SESSION['admin'])) {
            header('Location: ' . Parameters::$BASE_URL . 'Admin/showLogin');
            exit();
        }
    }

    private function redirectPanel(): void {
        header('Location: ' . Parameters::$BASE_URL . 'Admin/showPanel');
        exit();
    }

    private function validarPost(): array {
        $errores = [];
        if (strlen(trim($_POST['nombre'] ?? '')) < 3)
            $errores[] = 'El nombre es obligatorio (mínimo 3 caracteres).';
        if (!in_array($_POST['tipo'] ?? '', ['taller','ruta','charla','alojamiento']))
            $errores[] = 'El tipo de actividad no es válido.';
        if (!is_numeric($_POST['precio'] ?? '') || (float)$_POST['precio'] < 0)
            $errores[] = 'El precio debe ser un número positivo.';
        if (!is_numeric($_POST['duracion'] ?? '') || (int)$_POST['duracion'] <= 0)
            $errores[] = 'La duración debe ser un número entero positivo (en minutos).';
        if (empty(trim($_POST['descripcion_general'] ?? '')))
            $errores[] = 'La descripción general es obligatoria.';
        if ((int)($_POST['id_organizador'] ?? 0) <= 0)
            $errores[] = 'Debes seleccionar un organizador.';

        $inicios = $_POST['ses_inicio'] ?? [];
        $fines   = $_POST['ses_fin']    ?? [];
        $cupos   = $_POST['ses_cupo']   ?? [];
        foreach ($inicios as $i => $inicio) {
            if (empty($inicio)) continue;
            if (empty($fines[$i]))
                $errores[] = 'La sesión ' . ($i + 1) . ' necesita una fecha/hora de fin.';
            elseif ($fines[$i] <= $inicio)
                $errores[] = 'La sesión ' . ($i + 1) . ': la hora de fin debe ser posterior al inicio.';
            if (!isset($cupos[$i]) || (int)$cupos[$i] < 1)
                $errores[] = 'La sesión ' . ($i + 1) . ' necesita un cupo máximo de al menos 1.';
        }
        return $errores;
    }

    private function datosPost(): array {
        return [
            'nombre'              => trim($_POST['nombre']),
            'tipo'                => $_POST['tipo'],
            'descripcion_general' => trim($_POST['descripcion_general']),
            'precio'              => (float)$_POST['precio'],
            'duracion'            => (int)$_POST['duracion'],
            'estado'              => in_array($_POST['estado'] ?? '', ['activa','cancelada']) ? $_POST['estado'] : 'activa',
            'id_organizador'      => (int)$_POST['id_organizador'],
            'motivo_cancelacion'  => null,
        ];
    }

    private function datosSubtipoPost(string $tipo): array {
        return match($tipo) {
            'taller' => [
                'nivel'                => $_POST['nivel'] ?? 'iniciacion',
                'materiales_incluidos' => trim($_POST['materiales_incluidos'] ?? ''),
            ],
            'ruta' => [
                'dificultad'      => $_POST['dificultad'] ?? 'baja',
                'distancia_km'    => (float)($_POST['distancia_km'] ?? 0),
                'recomendaciones' => trim($_POST['recomendaciones'] ?? ''),
                'punto_inicio'    => trim($_POST['punto_inicio'] ?? ''),
                'punto_fin'       => trim($_POST['punto_fin'] ?? ''),
            ],
            'charla' => [
                'tema' => trim($_POST['tema'] ?? ''),
            ],
            'alojamiento' => [
                'tipo_alojamiento' => trim($_POST['tipo_alojamiento'] ?? ''),
                'noches'           => (int)($_POST['noches'] ?? 1),
                'regimen'          => $_POST['regimen'] ?? 'solo_alojamiento',
                'condiciones'      => trim($_POST['condiciones'] ?? ''),
            ],
            default => []
        };
    }

    private function insertarSubtipo(AdminActividadModel $model, int $idActividad, string $tipo): void {
        $model->insertarSubtipo($idActividad, $tipo, $this->datosSubtipoPost($tipo));
    }

    private function guardarSesiones(AdminActividadModel $model, int $idActividad): void {
        $ids     = $_POST['ses_id']     ?? [];
        $inicios = $_POST['ses_inicio'] ?? [];
        $fines   = $_POST['ses_fin']    ?? [];
        $cupos   = $_POST['ses_cupo']   ?? [];

        $idsEnviados = [];
        foreach ($inicios as $i => $inicio) {
            if (empty($inicio) || empty($fines[$i])) continue;
            $cupo  = max(1, (int)($cupos[$i] ?? 1));
            $sesId = (int)($ids[$i] ?? 0);
            if ($sesId > 0) {
                $model->actualizarSesion($sesId, $inicio, $fines[$i], $cupo);
                $idsEnviados[] = $sesId;
            } else {
                $nuevoId = $model->insertarSesion($idActividad, $inicio, $fines[$i], $cupo);
                if ($nuevoId) $idsEnviados[] = $nuevoId;
            }
        }
        $model->eliminarSesionesExcepto($idActividad, $idsEnviados);
    }
}