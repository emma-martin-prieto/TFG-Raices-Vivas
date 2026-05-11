<?php
namespace RaicesVivas\Controllers;

use RaicesVivas\Config\Parameters;
use RaicesVivas\Models\ActividadModel;
use RaicesVivas\Models\LocalidadModel;
use RaicesVivas\Models\PersonaModel;
use RaicesVivas\Entities\PersonaEntity;

class InscripcionController {

    /*Muestra el formulario con el resumen del carrito (sesiones) y las localidades.*/
    public function showFormulario(): void {
        $carrito        = $_SESSION['carrito'] ?? [];
        $actividadModel = new ActividadModel();
        $localidadModel = new LocalidadModel();
        $sesionesCarrito = [];

        foreach ($carrito as $idSesion) {
            $sesion = $actividadModel->getSesionById((int)$idSesion);
            if ($sesion) $sesionesCarrito[] = $sesion;
        }

        ViewController::show('views/inscripcion/showFormulario.php', [
            'sesionesCarrito' => $sesionesCarrito,
            'localidades'     => $localidadModel->getAll(),
            'errores'         => [],
            'dataPOST'        => []
        ]);
    }

    /*Procesa el formulario, guarda la persona en BD y redirige al éxito.*/
    public function procesar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            (new ErrorController())->mostrar404();
            return;
        }

        $nombre      = trim($_POST['nombre']       ?? '');
        $apellido1   = trim($_POST['apellido1']    ?? '');
        $apellido2   = trim($_POST['apellido2']    ?? '') ?: null;
        $email       = trim($_POST['email']        ?? '');
        $fechaNac    = trim($_POST['fecha_nac']    ?? '');
        $idLocalidad = (int)($_POST['id_localidad'] ?? 0);
        $notas       = trim($_POST['notas']        ?? '');
        $carrito     = $_SESSION['carrito']        ?? [];   // array de id_sesion

        // Validaciones
        $errores = [];

        if (strlen($nombre) < 2)
            $errores[] = 'El nombre es obligatorio.';
        if (strlen($apellido1) < 2)
            $errores[] = 'El primer apellido es obligatorio.';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            $errores[] = 'El correo electrónico no es válido.';
        if (empty($fechaNac))
            $errores[] = 'La fecha de nacimiento es obligatoria.';
        if ($idLocalidad <= 0)
            $errores[] = 'La provincia es obligatoria.';
        if (empty($carrito))
            $errores[] = 'No tienes ninguna actividad seleccionada.';

        // Comprobar email duplicado
        if (empty($errores)) {
            $personaModel = new PersonaModel();
            if ($personaModel->existeEmail($email))
                $errores[] = 'Ya existe una inscripción con ese correo electrónico.';
        }

        // ── Si hay errores volver al formulario
        if (!empty($errores)) {
            $actividadModel  = new ActividadModel();
            $localidadModel  = new LocalidadModel();
            $sesionesCarrito = [];

            foreach ($carrito as $idSesion) {
                $sesion = $actividadModel->getSesionById((int)$idSesion);
                if ($sesion) $sesionesCarrito[] = $sesion;
            }

            ViewController::show('views/inscripcion/showFormulario.php', [
                'sesionesCarrito' => $sesionesCarrito,
                'localidades'     => $localidadModel->getAll(),
                'errores'         => $errores,
                'dataPOST'        => $_POST
            ]);
            return;
        }

        // Generar código único RV-XXXXXXXX (8 caracteres alfanuméricos, sin 0/O/1/I para evitar confusiones)
        $personaModel = new PersonaModel();
        $caracteres   = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $aleatorio = '';
            for ($i = 0; $i < 8; $i++) {
                $aleatorio .= $caracteres[random_int(0, strlen($caracteres) - 1)];
            }
            $codigo = 'RV-' . $aleatorio;
        } while ($personaModel->existeCodigo($codigo));

        // Crear entidad y guardar en BD
        $persona = (new PersonaEntity())
            ->setCodigo($codigo)
            ->setNombre($nombre)
            ->setPriApe($apellido1)
            ->setSegApe($apellido2)
            ->setFechaNacimiento($fechaNac)
            ->setEmail($email)
            ->setIdLocalidad($idLocalidad);

        $ok = $personaModel->create($persona);

        if (!$ok) {
            ViewController::show('views/inscripcion/showFormulario.php', [
                'sesionesCarrito' => [],
                'localidades'     => (new LocalidadModel())->getAll(),
                'errores'         => ['Ha ocurrido un error al guardar tu inscripción. Inténtalo de nuevo.'],
                'dataPOST'        => $_POST
            ]);
            return;
        }

        // Obtener el id de la persona recién creada
        $idPersona = $personaModel->getIdByCodigo($codigo);

        // Inscribir directamente en cada sesión elegida (ya no buscamos la primera sesión)
        if ($idPersona) {
            foreach ($carrito as $idSesion) {
                $personaModel->inscribirEnSesion($idPersona, (int)$idSesion);
            }
        }

        // Éxito: guardar en sesión y redirigir
        $_SESSION['inscripcion_ok']     = true;
        $_SESSION['inscripcion_nombre'] = $nombre;
        $_SESSION['inscripcion_codigo'] = $codigo;
        unset($_SESSION['carrito']);

        header('Location: ' . Parameters::$BASE_URL . 'Inscripcion/showExito');
        exit();
    }

    /*Pantalla de éxito tras inscribirse.*/
    public function showExito(): void {
        if (empty($_SESSION['inscripcion_ok'])) {
            header('Location: ' . Parameters::$BASE_URL);
            exit();
        }

        $nombre = $_SESSION['inscripcion_nombre'] ?? '';
        $codigo = $_SESSION['inscripcion_codigo'] ?? '';
        unset($_SESSION['inscripcion_ok'], $_SESSION['inscripcion_nombre'], $_SESSION['inscripcion_codigo']);

        ViewController::show('views/inscripcion/showExito.php', [
            'nombre' => $nombre,
            'codigo' => $codigo
        ]);
    }

    /*busca una persona por su código RV y devuelve JSON con sus datos y las actividades de su carrito (persona_sesion).*/
    public function buscarCodigo(): void {
        $codigo = strtoupper(trim($_GET['codigo'] ?? ''));

        if (empty($codigo)) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['error' => 'Código no proporcionado.']);
            exit();
        }

        $personaModel = new PersonaModel();
        $resultado    = $personaModel->getByCodigoConActividades($codigo);

        header('Content-Type: application/json; charset=utf-8');

        if (!$resultado) {
            echo json_encode([
                'error'          => 'No se encontró ninguna inscripción con el código ',
                'codigo_buscado' => htmlspecialchars($codigo)
            ]);
            exit();
        }

        // Si el código pertenece a un ADMIN, redirigir al panel de administración
        if (($resultado['rol'] ?? '') === 'ADMIN') {
            echo json_encode(['redirect' => 'Admin/showLogin']);
            exit();
        }

        echo json_encode($resultado);
        exit();
    }
}