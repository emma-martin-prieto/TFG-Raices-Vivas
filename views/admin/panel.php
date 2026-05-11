<?php
use RaicesVivas\Config\Parameters;
$base = Parameters::$BASE_URL;
$actividades = $actividades ?? null;

$msg   = $_SESSION['admin_msg']   ?? null;
$error = $_SESSION['admin_error'] ?? null;
unset($_SESSION['admin_msg'], $_SESSION['admin_error']);

function badgeEstado(string $estado): string {
    return match($estado) {
        'activa'    => '<span class="badge bg-success">Activa</span>',
        'cancelada' => '<span class="badge bg-danger">Cancelada</span>',
        'pendiente' => '<span class="badge bg-warning text-dark">Pendiente</span>',
        default     => '<span class="badge bg-secondary">' . htmlspecialchars($estado) . '</span>',
    };
}

function badgeTipoAdmin(string $tipo): string {
    return match($tipo) {
        'taller'      => '<span class="badge bg-naranja-rv">Taller</span>',
        'ruta'        => '<span class="badge bg-primary">Ruta</span>',
        'charla'      => '<span class="badge bg-success">Charla</span>',
        'alojamiento' => '<span class="badge bg-info text-dark">Alojamiento</span>',
        default       => '<span class="badge bg-secondary">' . htmlspecialchars($tipo) . '</span>',
    };
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | Panel de Administración</title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<!-- Barra superior de admin -->
<div class="admin-topbar">
    <div class="brand">
        <i class="bi bi-shield-lock-fill"></i>
        Raíces Vivas
        <span class="admin-badge">Admin</span>
    </div>
    <div class="d-flex align-items-center gap-3">
        <span class="opacity-75 small"><i class="bi bi-person-fill me-1"></i>Modo administrador activo</span>
        <a href="<?= $base ?>Admin/logout"
           class="btn btn-sm btn-outline-light rounded-pill px-3">
            <i class="bi bi-box-arrow-right me-1"></i>Salir
        </a>
    </div>
</div>

<main class="container py-5">

    <!-- Cabecera del panel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-verde-rv mb-0" style="font-size:1.75rem;">
                <i class="bi bi-grid-3x3-gap-fill me-2"></i>Gestión de Experiencias
            </h1>
            <p class="text-muted small mb-0 mt-1">
                <?= count($actividades ?? []) ?> experiencias en total
            </p>
        </div>
        <a href="<?= $base ?>Admin/showCrear"
           class="btn btn-naranja-rv rounded-pill px-4">
            <i class="bi bi-plus-circle-fill me-2"></i>Nueva experiencia
        </a>
    </div>

    <!-- Mensajes de éxito / error -->
    <?php if ($msg): ?>
    <div class="alert alert-success alert-dismissible fade show rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-check-circle-fill fs-5"></i>
        <span><?= htmlspecialchars($msg) ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if ($error): ?>
    <div class="alert alert-danger alert-dismissible fade show rounded-3 d-flex align-items-center gap-2 mb-4" role="alert">
        <i class="bi bi-x-circle-fill fs-5"></i>
        <span><?= htmlspecialchars($error) ?></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Tabla de actividades -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table admin-table table-hover mb-0">
                <thead class="bg-white border-bottom">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th class="py-3">Nombre</th>
                        <th class="py-3">Tipo</th>
                        <th class="py-3">Precio</th>
                        <th class="py-3">Duración</th>
                        <th class="py-3">Organizador</th>
                        <th class="py-3">Estado</th>
                        <th class="py-3 text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($actividades): ?>
                        <?php foreach ($actividades as $act): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $act->id ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($act->nombre) ?></td>
                            <td><?= badgeTipoAdmin($act->tipo) ?></td>
                            <td class="precio-col"><?= number_format($act->precio, 2) ?> €</td>
                            <td class="text-muted"><?= $act->duracion ?> min</td>
                            <td class="text-muted small"><?= htmlspecialchars($act->organizador) ?></td>
                            <td><?= badgeEstado($act->estado) ?></td>
                            <td class="text-center pe-4">
                                <div class="d-flex gap-2 justify-content-center">
                                    <!-- Editar -->
                                    <a href="<?= $base ?>Admin/showEditar&id=<?= $act->id ?>"
                                       class="btn btn-outline-secondary btn-accion"
                                       data-bs-toggle="tooltip" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <!-- Eliminar -->
                                    <button type="button"
                                            class="btn btn-outline-danger btn-accion btn-eliminar"
                                            data-id="<?= $act->id ?>"
                                            data-nombre="<?= htmlspecialchars($act->nombre) ?>"
                                            data-bs-toggle="tooltip" title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                No hay experiencias registradas.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── SECCIÓN ORGANIZADORES ── -->
    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
        <div>
            <h2 class="fw-bold text-verde-rv mb-0" style="font-size:1.4rem;">
                <i class="bi bi-building me-2"></i>Gestión de Organizadores
            </h2>
            <p class="text-muted small mb-0 mt-1">
                <?= count($organizadores ?? []) ?> organizadores registrados
            </p>
        </div>
        <button class="btn btn-naranja-rv rounded-pill px-4"
                data-bs-toggle="modal" data-bs-target="#modalOrganizador"
                id="btn-nuevo-org">
            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo organizador
        </button>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="table-responsive">
            <table class="table admin-table table-hover mb-0">
                <thead class="bg-white border-bottom">
                    <tr>
                        <th class="ps-4 py-3">ID</th>
                        <th class="py-3">Nombre</th>
                        <th class="py-3">Tipo</th>
                        <th class="py-3 text-center pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($organizadores)): ?>
                        <?php foreach ($organizadores as $org): ?>
                        <tr>
                            <td class="ps-4 text-muted"><?= $org->id ?></td>
                            <td class="fw-semibold"><?= htmlspecialchars($org->nombre) ?></td>
                            <td>
                                <?php $tipoOrg = match($org->tipo) {
                                    'empresa'       => ['bg-primary',   'Empresa'],
                                    'asociacion'    => ['bg-success',   'Asociación'],
                                    'ayuntamiento'  => ['bg-info text-dark', 'Ayuntamiento'],
                                    'autonomo'      => ['bg-naranja-rv','Autónomo'],
                                    default         => ['bg-secondary', ucfirst($org->tipo)]
                                }; ?>
                                <span class="badge <?= $tipoOrg[0] ?>"><?= $tipoOrg[1] ?></span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button type="button"
                                            class="btn btn-outline-secondary btn-accion btn-editar-org"
                                            data-id="<?= $org->id ?>"
                                            data-nombre="<?= htmlspecialchars($org->nombre) ?>"
                                            data-tipo="<?= $org->tipo ?>"
                                            data-bs-toggle="tooltip" title="Editar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-outline-danger btn-accion btn-eliminar-org"
                                            data-id="<?= $org->id ?>"
                                            data-nombre="<?= htmlspecialchars($org->nombre) ?>"
                                            data-bs-toggle="tooltip" title="Eliminar">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-building fs-2 d-block mb-2 opacity-50"></i>
                                No hay organizadores registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<!-- Modal crear/editar organizador -->
<div class="modal fade" id="modalOrganizador" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="modalOrgTitulo">
                    <i class="bi bi-building me-2 text-verde-rv"></i>Nuevo organizador
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="" id="form-organizador">
                <input type="hidden" name="id" id="org-id">
                <div class="modal-body px-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" name="nombre" id="org-nombre"
                               class="form-control" required minlength="3"
                               placeholder="Nombre del organizador">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tipo</label>
                        <select name="tipo" id="org-tipo" class="form-select" required>
                            <option value="empresa">Empresa</option>
                            <option value="asociacion">Asociación</option>
                            <option value="ayuntamiento">Ayuntamiento</option>
                            <option value="autonomo">Autónomo</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-naranja-rv rounded-pill px-4">
                        <i class="bi bi-check-circle me-1"></i><span id="org-btn-txt">Crear</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal confirmar eliminar organizador -->
<div class="modal fade" id="modalEliminarOrg" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Confirmar eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-0">
                <p class="text-muted mb-0">
                    Vas a eliminar el organizador <strong id="modal-nombre-org"></strong>.
                    No podrás eliminarlo si tiene actividades asociadas.
                </p>
            </div>
            <div class="modal-footer border-0 pt-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                        data-bs-dismiss="modal">Cancelar</button>
                <form method="POST" action="<?= $base ?>Admin/eliminarOrganizador" id="form-eliminar-org">
                    <input type="hidden" name="id" id="input-id-eliminar-org">
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash3-fill me-1"></i>Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de borrado -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                    Confirmar eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pb-0">
                <p class="text-muted mb-0">
                    Vas a eliminar la experiencia <strong id="modal-nombre-act"></strong>.
                    Esta acción no se puede deshacer.
                </p>
            </div>
            <div class="modal-footer border-0 pt-3">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>
                <form method="POST" action="<?= $base ?>Admin/eliminar" id="form-eliminar">
                    <input type="hidden" name="id" id="input-id-eliminar">
                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash3-fill me-1"></i>Sí, eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>
<script>
// ── Organizadores
const modalOrg       = document.getElementById('modalOrganizador');
const formOrg        = document.getElementById('form-organizador');
const orgId          = document.getElementById('org-id');
const orgNombre      = document.getElementById('org-nombre');
const orgTipo        = document.getElementById('org-tipo');
const orgTitulo      = document.getElementById('modalOrgTitulo');
const orgBtnTxt      = document.getElementById('org-btn-txt');
const base           = '<?= $base ?>';

// Nuevo organizador — limpiar el modal
document.getElementById('btn-nuevo-org').addEventListener('click', function () {
    orgTitulo.innerHTML = '<i class="bi bi-building me-2 text-verde-rv"></i>Nuevo organizador';
    orgBtnTxt.textContent = 'Crear';
    orgId.value     = '';
    orgNombre.value = '';
    orgTipo.value   = 'empresa';
    formOrg.action  = base + 'Admin/crearOrganizador';
});

// Editar organizador — rellenar con los datos del botón
document.querySelectorAll('.btn-editar-org').forEach(function (btn) {
    btn.addEventListener('click', function () {
        orgTitulo.innerHTML = '<i class="bi bi-pencil-fill me-2 text-verde-rv"></i>Editar organizador';
        orgBtnTxt.textContent = 'Guardar';
        orgId.value     = this.dataset.id;
        orgNombre.value = this.dataset.nombre;
        orgTipo.value   = this.dataset.tipo;
        formOrg.action  = base + 'Admin/editarOrganizador';
        new bootstrap.Modal(modalOrg).show();
    });
});

// Eliminar organizador
document.querySelectorAll('.btn-eliminar-org').forEach(function (btn) {
    btn.addEventListener('click', function () {
        document.getElementById('modal-nombre-org').textContent = this.dataset.nombre;
        document.getElementById('input-id-eliminar-org').value  = this.dataset.id;
        new bootstrap.Modal(document.getElementById('modalEliminarOrg')).show();
    });
});
</script>
</body>
</html>