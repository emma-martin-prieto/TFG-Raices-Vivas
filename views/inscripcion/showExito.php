<?php
use RaicesVivas\Config\Parameters;
$base = Parameters::$BASE_URL;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | ¡Inscripción enviada!</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<?php require_once 'views/partials/header.php'; ?>

<main class="py-5 bg-light min-vh-100 d-flex align-items-center">
    <div class="container text-center py-5">

        <i class="bi bi-patch-check-fill display-1 text-verde-rv mb-4 d-block"></i>

        <h2 class="display-4 fw-bold text-verde-rv mb-3">¡Inscripción enviada!</h2>

        <p class="lead text-muted mb-4">
            <?php if ($nombre): ?>
                Gracias, <strong><?= htmlspecialchars($nombre) ?></strong>.
            <?php endif; ?>
            Hemos recibido tu solicitud. En breve recibirás un correo con todos los detalles.
        </p>

        <?php if ($codigo): ?>
        <div class="card border-0 shadow-sm rounded-4 d-inline-block px-5 py-4 mb-5 bg-white">
            <p class="text-muted small mb-1 text-uppercase fw-semibold">Tu código de inscripción</p>
            <p class="display-5 fw-bold text-verde-rv mb-1 font-monospace"><?= htmlspecialchars($codigo) ?></p>
            <p class="text-muted small">Guárdalo, lo necesitarás para cualquier consulta.</p>
        </div>
        <?php endif; ?>

        <div class="d-flex gap-3 justify-content-center">
            <a href="<?= $base ?>index.php"
               class="btn btn-naranja-rv rounded-pill px-5 py-3 fw-bold">
                <i class="bi bi-house-fill me-2"></i>Volver al inicio
            </a>
            <a href="<?= $base ?>index.php?controller=Actividad&action=showExperiencias"
               class="btn btn-outline-verde-rv rounded-pill px-5 py-3 fw-bold">
                <i class="bi bi-compass me-2"></i>Ver más experiencias
            </a>
        </div>

    </div>
</main>

<?php require_once 'views/partials/footer.php'; ?>
<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>