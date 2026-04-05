<?php
// ── Helpers

function badgeTipo(string $tipo): string {
    return match($tipo) {
        'taller'      => '<span class="badge bg-naranja-rv position-absolute top-0 start-0 m-3">Taller</span>',
        'ruta'        => '<span class="badge bg-primary position-absolute top-0 start-0 m-3 text-white">Ruta</span>',
        'charla'      => '<span class="badge bg-success position-absolute top-0 start-0 m-3">Charla</span>',
        'alojamiento' => '<span class="badge bg-info text-dark position-absolute top-0 start-0 m-3">Estancia</span>',
        default       => ''
    };
}

function imagenActividad(object $act): string {
    $mapa = [
        'Cocina de la Sierra'                          => 'cocina-tipica.jpg',
        'Cestos de Mimbre'                             => 'mimbre.JPG',
        'Pesca Tradicional'                            => 'cultivo-pesca.jpg',
        'Cultivo Tradicional'                          => 'cultivo.jpg',
        'Juegos Tradicionales'                         => 'juegos-tradicionales.jpg',
        'Laguna Grande de Gredos'                      => 'laguna-grande.jpg',
        'Subida a La Espesura'                         => 'espesura.jpeg',
        '5 Lagunas de Gredos'                          => '5lagunas.jpg',
        'Senda del Río Tormes'                         => 'ruta-rio.jpg',
        'Secretos de Gredos'                           => 'flora.jpg',
        'Memoria de la Pobreza'                        => 'abuelos.jpeg',
        'La Elaboración de la Matanza'                 => 'matanza.jpg',
        'La Vida del Pastor'                           => 'pastores.jpg',
        'Lo que Gredos Calla'                          => 'anecdotas.jpg',
        'Bailes, Vestimenta y Canciones Tradicionales' => 'bailes.jpeg',
        'La Casa de la Plaza'                          => 'casa-rural.JPG',
        'Casa Rural El Pinta'                          => 'casa-aliseda.jpg',
        'Casa Rural La Tabilla'                        => 'casa-navalperal.jpg',
    ];
    return $mapa[$act->nombre] ?? 'logo.png';
}

function iconoActividad(object $act): string {
    return match($act->tipo) {
        'taller'      => 'bi-hand-index-thumb',
        'ruta'        => 'bi-signpost-split',
        'charla'      => 'bi-chat-quote',
        'alojamiento' => 'bi-house-heart',
        default       => 'bi-star'
    };
}

function labelFiltro(string $tipo): string {
    return match($tipo) {
        'taller'      => 'talleres',
        'ruta'        => 'rutas',
        'charla'      => 'charlas',
        'alojamiento' => 'alojamiento',
        default       => $tipo
    };
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | Experiencias</title>

    <?php
    use RaicesVivas\Config\Parameters;
    $base = Parameters::$BASE_URL;
    ?>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body>

<?php require_once 'views/partials/header.php'; ?>

<main class="py-5 bg-light">
    <div class="container">

        <!-- Cabecera -->
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="display-4 fw-bold text-verde-rv">Experiencias Raíces Vivas</h1>
            <div class="section-line mx-auto"></div>
            <p class="lead text-muted">Siente la Sierra de Gredos a través de sus oficios y sabores.</p>
        </div>

        <!-- Filtros -->
        <div class="d-flex justify-content-center mb-5" data-aos="fade-up">
            <div class="contenedor-filtros shadow-sm rounded-pill-md bg-white p-2" role="group" aria-label="Filtros">
                <button type="button" class="btn btn-filter active rounded-pill px-4" data-filter="all">Todas</button>
                <button type="button" class="btn btn-filter rounded-pill px-4" data-filter="talleres">Talleres</button>
                <button type="button" class="btn btn-filter rounded-pill px-4" data-filter="rutas">Rutas</button>
                <button type="button" class="btn btn-filter rounded-pill px-4" data-filter="charlas">Charlas</button>
                <button type="button" class="btn btn-filter rounded-pill px-4" data-filter="alojamiento">Alojamiento</button>
            </div>
        </div>

        <!-- Grid de actividades -->
        <div class="row g-4" id="experience-grid">

            <?php if ($actividades): ?>
                <?php foreach ($actividades as $act): ?>

                <?php $filtroClass = labelFiltro($act->tipo); ?>

                <div class="col-lg-4 col-md-6 filter-item <?= $filtroClass ?>" data-aos="zoom-in">
                    <div class="card h-100 border-0 shadow-sm card-experiencia">

                        <!-- Imagen + badge -->
                        <div class="position-relative overflow-hidden experiencia-img-wrapper">
                            <img src="<?= $base ?>assets/img/<?= imagenActividad($act) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars($act->nombre) ?>">
                            <?= badgeTipo($act->tipo) ?>
                        </div>

                        <!-- Cuerpo -->
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($act->nombre) ?></h5>
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars(mb_substr($act->descripcion_general, 0, 120)) ?>...
                            </p>

                            <!-- Icono + precio + duración + cupo -->
                            <div class="d-flex gap-3 my-3 text-verde-rv align-items-center">
                                <i class="bi <?= iconoActividad($act) ?> fs-5"
                                   data-bs-toggle="tooltip"
                                   title="<?= ucfirst($act->tipo) ?>"></i>
                                <span class="small fw-bold">
                                    <?= number_format($act->precio, 2) ?> €
                                </span>
                                <span class="small text-muted">
                                    <?= $act->duracion ?> min
                                </span>
                                <?php if ($act->cupo_max): ?>
                                <span class="small text-muted">
                                    <i class="bi bi-people-fill me-1"></i><?= $act->cupo_max ?> plazas
                                </span>
                                <?php endif; ?>
                            </div>

                            <!-- Botones -->
                            <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                <button class="btn btn-outline-verde-rv btn-sm px-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modal-<?= $act->id ?>">
                                    Detalles
                                </button>
                                <button class="btn btn-naranja-rv btn-sm px-3 btn-reservar"
                                        data-id="<?= $act->id ?>"
                                        data-base="<?= $base ?>">
                                    <i class="bi bi-bag-plus me-1"></i>Reservar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal de detalle -->
                <div class="modal fade" id="modal-<?= $act->id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content border-0 rounded-4 shadow">
                            <div class="modal-header border-0 pb-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4 pt-0 text-center">
                                <img src="<?= $base ?>assets/img/<?= imagenActividad($act) ?>"
                                     class="img-fluid rounded-4 mb-3 shadow-sm"
                                     alt="<?= htmlspecialchars($act->nombre) ?>">
                                <h2 class="fw-bold text-verde-rv"><?= htmlspecialchars($act->nombre) ?></h2>
                                <p class="text-muted text-start"><?= htmlspecialchars($act->descripcion_general) ?></p>

                                <!-- Datos específicos según tipo -->
                                <div class="text-start mt-3">
                                    <?php if ($act->tipo === 'taller'): ?>
                                        <p><strong>Nivel:</strong> <?= ucfirst($act->nivel) ?></p>
                                        <p><strong>Materiales incluidos:</strong> <?= htmlspecialchars($act->materiales_incluidos) ?></p>

                                    <?php elseif ($act->tipo === 'ruta'): ?>
                                        <p><strong>Dificultad:</strong> <?= ucfirst($act->dificultad) ?></p>
                                        <p><strong>Distancia:</strong> <?= $act->distancia_km ?> km</p>
                                        <p><strong>Inicio:</strong> <?= htmlspecialchars($act->punto_inicio) ?></p>
                                        <p><strong>Fin:</strong> <?= htmlspecialchars($act->punto_fin) ?></p>
                                        <?php if ($act->recomendaciones): ?>
                                        <p><strong>Recomendaciones:</strong> <?= htmlspecialchars($act->recomendaciones) ?></p>
                                        <?php endif; ?>

                                    <?php elseif ($act->tipo === 'charla'): ?>
                                        <p><strong>Tema:</strong> <?= htmlspecialchars($act->tema) ?></p>

                                    <?php elseif ($act->tipo === 'alojamiento'): ?>
                                        <p><strong>Tipo:</strong> <?= htmlspecialchars($act->tipo_alojamiento) ?></p>
                                        <p><strong>Noches:</strong> <?= $act->noches ?></p>
                                        <p><strong>Régimen:</strong> <?= str_replace('_', ' ', $act->regimen) ?></p>
                                        <?php if ($act->condiciones): ?>
                                        <p><strong>Condiciones:</strong> <?= htmlspecialchars($act->condiciones) ?></p>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <!-- Sesión: horas y cupo -->
                                    <?php if ($act->fecha_hora_inicio): ?>
                                    <hr class="my-3">
                                    <p>
                                        <strong><i class="bi bi-clock me-1"></i>Hora de inicio:</strong>
                                        <?= date('d/m/Y H:i', strtotime($act->fecha_hora_inicio)) ?>
                                    </p>
                                    <p>
                                        <strong><i class="bi bi-clock-history me-1"></i>Hora de fin:</strong>
                                        <?= date('d/m/Y H:i', strtotime($act->fecha_hora_fin)) ?>
                                    </p>
                                    <p>
                                        <strong><i class="bi bi-people-fill me-1"></i>Plazas disponibles:</strong>
                                        <?= $act->cupo_max ?>
                                    </p>
                                    <?php endif; ?>

                                    <hr class="my-3">
                                    <p>
                                        <strong>Precio:</strong>
                                        <span class="text-verde-rv fw-bold"><?= number_format($act->precio, 2) ?> €</span>
                                        &nbsp;·&nbsp;
                                        <strong>Duración:</strong> <?= $act->duracion ?> min
                                    </p>
                                    <p><strong>Organiza:</strong> <?= htmlspecialchars($act->organizador) ?></p>
                                </div>
                            </div>
                            <div class="modal-footer border-0 justify-content-center pb-4">
                                <a href="<?= $base ?>index.php?controller=Inscripcion&action=showFormulario&id=<?= $act->id ?>"
                                   class="btn btn-naranja-rv rounded-pill px-5">
                                    Reservar ahora
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>

            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No hay actividades disponibles en este momento.</p>
                </div>
            <?php endif; ?>

        </div><!-- /row -->

        <!-- Botón inscripción -->
        <div class="text-center mt-5 pt-4">
            <a href="<?= $base ?>index.php?controller=Inscripcion&action=showFormulario"
               class="btn btn-verde-rv btn-lg rounded-pill px-5 py-3">
                <i class="bi bi-check-circle-fill me-2"></i>Confirmar Selección e Inscribirse
            </a>
        </div>

    </div>
</main>

<?php require_once 'views/partials/footer.php'; ?>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>

<!-- Toast notificación carrito -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="toastCarrito" class="toast align-items-center text-white border-0 shadow" role="alert">
        <div class="d-flex">
            <div class="toast-body fw-semibold" id="toastMensaje">
                ¡Añadido a tu selección!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toastEl  = document.getElementById('toastCarrito');
    const toastMsg = document.getElementById('toastMensaje');
    const toast    = new bootstrap.Toast(toastEl, { delay: 3000 });

    document.querySelectorAll('.btn-reservar').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const base = this.dataset.base;

            fetch(base + 'index.php?controller=Carrito&action=aniadir&id=' + id)
                .then(r => r.json())
                .then(data => {
                    if (data.ok) {
                        toastEl.classList.remove('bg-danger', 'bg-success');
                        toastEl.classList.add('bg-success');
                    } else {
                        toastEl.classList.remove('bg-danger', 'bg-success');
                        toastEl.classList.add('bg-danger');
                    }
                    toastMsg.textContent = data.mensaje;
                    toast.show();
                });
        });
    });

});
</script>
</body>
</html>