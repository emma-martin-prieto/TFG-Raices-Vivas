<?php
use RaicesVivas\Config\Parameters;
$base  = Parameters::$BASE_URL;
$error = $_SESSION['admin_login_error'] ?? null;
unset($_SESSION['admin_login_error']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | Acceso administrador</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="admin-login-body">

<div class="admin-login-wrap">
    <div class="admin-login-caja">

        <div class="admin-login-icono">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h1 class="admin-login-titulo">Acceso administrador</h1>
        <p class="admin-login-sub">Introduce de nuevo el código de acceso para gestionar las experiencias.</p>

        <form method="POST" action="<?= $base ?>index.php?controller=Admin&action=verificarCodigo" id="form-admin-login">
            <div class="admin-login-input-wrap">
                <input type="text" name="codigo" id="input-admin-codigo"
                       class="admin-login-input <?= $error ? 'input-error' : '' ?>"
                       autocomplete="off" spellcheck="false" maxlength="30"
                       autofocus>
                <button type="submit" class="admin-login-btn">
                    <i class="bi bi-arrow-right-circle-fill"></i>
                </button>
            </div>

            <?php if ($error): ?>
            <div class="admin-login-error">
                <i class="bi bi-exclamation-circle-fill me-1"></i>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
        </form>

        <a href="<?= $base ?>index.php" class="admin-login-volver">
            <i class="bi bi-arrow-left me-1"></i>Volver al inicio
        </a>

    </div>
</div>
</body>
</html>