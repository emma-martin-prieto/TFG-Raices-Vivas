<?php
use RaicesVivas\Config\Parameters;
$base = Parameters::$BASE_URL;

$totalCarrito = count($actividadesCarrito ?? []);
$precioTotal  = array_sum(array_map(fn($a) => $a->precio, $actividadesCarrito ?? []));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | Inscripción</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

<?php require_once 'views/layout/header.php'; ?>

<main class="py-5 bg-light min-vh-100">
    <div class="container">

        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-4 fw-bold text-verde-rv">¡Prepara tu mochila!</h1>
            <p class="lead text-muted">Estás a un paso de vivir la Sierra de Gredos de una forma única.</p>
        </div>

        <!-- Errores -->
        <?php if (!empty($errores)): ?>
        <div class="alert alert-danger mb-4" data-aos="fade-down">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="row g-4" data-aos="fade-up">

            <!-- ── COLUMNA IZQUIERDA: resumen carrito ── -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-top sidebar-sticky">
                    <div class="card-header bg-verde-rv text-white rounded-top-4 py-3 px-4">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-bag-check-fill me-2"></i>Tu selección
                            <span class="badge bg-naranja-rv ms-2"><?= $totalCarrito ?></span>
                        </h5>
                    </div>
                    <div class="card-body p-0">

                        <?php if (empty($actividadesCarrito)): ?>
                            <div class="text-center text-muted py-5 px-4">
                                <i class="bi bi-bag fs-1 d-block mb-3 opacity-25"></i>
                                <p class="small">Aún no has añadido ninguna actividad.</p>
                                <a href="<?= $base ?>Actividad/showExperiencias"
                                   class="btn btn-outline-verde-rv btn-sm rounded-pill px-4">
                                    Ver experiencias
                                </a>
                            </div>
                        <?php else: ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($actividadesCarrito as $act): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start py-3 px-4">
                                    <div>
                                        <p class="mb-0 fw-semibold small"><?= htmlspecialchars($act->nombre) ?></p>
                                        <span class="text-verde-rv fw-bold small"><?= number_format($act->precio, 2) ?> €</span>
                                    </div>
                                    <a href="<?= $base ?>Carrito/eliminar?id=<?= $act->id ?>"
                                       class="text-danger ms-2" title="Eliminar">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total</span>
                                <span class="fw-bold text-verde-rv fs-5"><?= number_format($precioTotal, 2) ?> €</span>
                            </div>

                            <div class="px-4 pb-3">
                                <a href="<?= $base ?>Carrito/vaciar"
                                   class="btn btn-outline-danger btn-sm w-100 rounded-pill">
                                    <i class="bi bi-trash me-1"></i>Vaciar selección
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <!-- ── COLUMNA DERECHA: formulario ── -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">

                        <form id="form-inscripcion" method="POST"
                              action="<?= $base ?>Inscripcion/procesar"
                              class="needs-validation" novalidate>

                            <!-- 1. Datos personales -->
                            <h5 class="fw-bold text-verde-rv mb-4 border-bottom pb-2">
                                <i class="bi bi-card-text me-2"></i>1. Datos del Explorador
                            </h5>
                            <div class="row g-3 mb-5">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-person"></i></span>
                                        <input type="text" name="nombre" id="nombre" class="form-control custom-input"
                                               placeholder="Nombre" required
                                               value="<?= htmlspecialchars($dataPOST['nombre'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" name="apellido1" id="apellido1" class="form-control custom-input"
                                               placeholder="Primer Apellido" required
                                               value="<?= htmlspecialchars($dataPOST['apellido1'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-person-vcard"></i></span>
                                        <input type="text" name="apellido2" id="apellido2" class="form-control custom-input"
                                               placeholder="Segundo Apellido"
                                               value="<?= htmlspecialchars($dataPOST['apellido2'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-envelope-at"></i></span>
                                        <input type="email" name="email" id="email" class="form-control custom-input"
                                               placeholder="Correo electrónico" required
                                               value="<?= htmlspecialchars($dataPOST['email'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-calendar-event"></i></span>
                                        <input type="date" name="fecha_nac" id="fecha_nac" class="form-control custom-input" required
                                               value="<?= htmlspecialchars($dataPOST['fecha_nac'] ?? '') ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <span class="input-group-text icon-input"><i class="bi bi-geo-alt"></i></span>
                                        <select name="id_localidad" id="id_localidad" class="form-select custom-input" required>
                                            <option value="" disabled <?= empty($dataPOST['id_localidad']) ? 'selected' : '' ?>>
                                                Provincia...
                                            </option>
                                            <?php if ($localidades): ?>
                                                <?php foreach ($localidades as $loc): ?>
                                                <option value="<?= $loc->id ?>"
                                                    <?= (isset($dataPOST['id_localidad']) && $dataPOST['id_localidad'] == $loc->id) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($loc->nombre) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Notas -->
                            <h5 class="fw-bold text-verde-rv mb-4 border-bottom pb-2">
                                <i class="bi bi-journal-text me-2"></i>2. Notas de Campo
                            </h5>
                            <div class="input-group mb-5">
                                <span class="input-group-text icon-input"><i class="bi bi-chat-left-dots"></i></span>
                                <textarea name="notas" class="form-control custom-input" rows="3"
                                          placeholder="¿Vienes con mascota? ¿Alguna alergia? Cuéntanos..."><?= htmlspecialchars($dataPOST['notas'] ?? '') ?></textarea>
                            </div>

                            <!-- Botón enviar -->
                            <button type="submit" <?= empty($actividadesCarrito) ? 'disabled' : '' ?>
                                    class="btn btn-naranja-rv btn-lg w-100 rounded-pill fw-bold py-3">
                                <i class="bi bi-check-circle-fill me-2"></i>¡CONFIRMAR MI EXPEDICIÓN!
                            </button>

                            <?php if (empty($actividadesCarrito)): ?>
                            <p class="text-center text-muted small mt-2">
                                Añade al menos una actividad para poder inscribirte.
                            </p>
                            <?php endif; ?>

                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- ── BUSCADOR DE INSCRIPCIÓN POR CÓDIGO ── -->
        <div class="row justify-content-center mt-5" data-aos="fade-up">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-verde-rv text-white py-3 px-4">
                        <h5 class="mb-0 fw-bold">
                            <i class="bi bi-search me-2"></i>Consulta tu inscripción
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted small mb-3">
                            ¿Ya tienes un código? Introdúcelo para ver las actividades que has reservado.
                        </p>

                        <!-- Formulario de búsqueda -->
                        <div class="input-group mb-3">
                            <span class="input-group-text icon-input">
                                <i class="bi bi-qr-code"></i>
                            </span>
                            <input type="text" id="buscar-codigo"
                                   class="form-control custom-input text-uppercase"
                                   placeholder="Introduce tu código de inscripción">
                            <button class="btn btn-naranja-rv px-4 fw-bold"
                                    id="btn-buscar-codigo" type="button">
                                Buscar
                            </button>
                        </div>

                        <!-- Resultado -->
                        <div id="resultado-codigo" class="d-none" data-base="<?= $base ?>"></div>

                        <!-- Templates HTML — el JS los clona y rellena, no genera HTML propio -->

                        <template id="tpl-resultado">
                            <div class="border rounded-4 overflow-hidden">
                                <div class="bg-verde-rv text-white px-4 py-3 d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-0 small opacity-75">Inscripción encontrada</p>
                                        <h6 class="mb-0 fw-bold js-nombre-persona"></h6>
                                    </div>
                                    <span class="badge bg-naranja-rv fs-6 font-monospace js-codigo-persona"></span>
                                </div>
                                <div class="px-4 py-3 bg-white border-bottom">
                                    <p class="mb-0 small text-muted">
                                        <i class="bi bi-envelope me-1"></i><span class="js-email-persona"></span>
                                        &nbsp;·&nbsp;
                                        <i class="bi bi-calendar me-1"></i>Registrado el <span class="js-fecha-persona"></span>
                                    </p>
                                </div>
                                <div class="bg-white">
                                    <p class="px-4 pt-3 mb-1 small fw-bold text-verde-rv text-uppercase">
                                        <i class="bi bi-bag-check me-1"></i>Actividades reservadas
                                    </p>
                                    <ul class="list-group list-group-flush js-lista-actividades"></ul>
                                </div>
                            </div>
                        </template>

                        <template id="tpl-actividad-normal">
                            <li class="list-group-item py-2 px-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold small js-act-nombre"></span>
                                        <span class="badge ms-2 js-act-badge"></span>
                                    </div>
                                    <span class="fw-bold text-verde-rv small js-act-precio"></span>
                                </div>
                            </li>
                        </template>

                        <template id="tpl-actividad-cancelada">
                            <li class="list-group-item py-2 px-3 bg-danger-subtle">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="fw-semibold small text-decoration-line-through text-muted js-act-nombre"></span>
                                        <span class="badge ms-2 bg-danger">Cancelada</span>
                                    </div>
                                    <span class="fw-bold small text-muted text-decoration-line-through js-act-precio"></span>
                                </div>
                                <div class="aviso-cancelacion mt-2 p-2 rounded-3 border border-danger-subtle d-flex gap-2 align-items-start">
                                    <i class="bi bi-exclamation-triangle-fill text-danger mt-1 flex-shrink-0"></i>
                                    <div>
                                        <p class="mb-0 small fw-bold text-danger">Esta actividad ha sido cancelada</p>
                                        <p class="mb-0 small text-muted mt-1 js-act-motivo"></p>
                                        <p class="mb-0 small text-muted mt-1">Si tienes dudas sobre tu reserva, contacta con la organización.</p>
                                    </div>
                                </div>
                            </li>
                        </template>

                        <template id="tpl-sin-actividades">
                            <li class="list-group-item text-muted small py-2 px-3">Sin actividades registradas.</li>
                        </template>

                        <template id="tpl-alerta-warning">
                            <div class="alert alert-warning rounded-3 mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span class="js-alerta-texto"></span>
                            </div>
                        </template>

                        <template id="tpl-alerta-danger">
                            <div class="alert alert-danger rounded-3 mb-0 d-flex align-items-center gap-2">
                                <i class="bi bi-x-circle-fill"></i>
                                <span class="js-alerta-texto"></span>
                                <strong class="js-alerta-codigo d-none"></strong>
                                <span class="js-alerta-punto d-none">.</span>
                            </div>
                        </template>

                        <template id="tpl-spinner">
                            <div class="py-2 d-flex align-items-center gap-2">
                                <div class="spinner-border spinner-border-sm text-verde-rv"></div>
                                <span class="text-muted small">Buscando...</span>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>
</body>
</html>