<?php
use RaicesVivas\Config\Parameters;
$base     = Parameters::$BASE_URL;
$esEditar = ($modo === 'editar' && $actividad !== null);
$titulo   = $esEditar ? 'Editar experiencia' : 'Nueva experiencia';
$action   = $esEditar ? 'editar' : 'crear';

$v = function(string $campo, mixed $default = '') use ($actividad): mixed {
    if ($actividad && isset($actividad->$campo)) return $actividad->$campo;
    return $default;
};
$sel = function(string $campo, string $valor) use ($v): string {
    return $v($campo) == $valor ? 'selected' : '';
};
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raíces Vivas | <?= $titulo ?></title>
    <link rel="stylesheet" href="<?= $base ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $base ?>assets/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="admin-topbar">
    <div class="brand">
        <i class="bi bi-shield-lock-fill"></i>
        Raíces Vivas
        <span class="admin-badge">Admin</span>
    </div>
    <a href="<?= $base ?>Admin/showPanel"
       class="btn btn-sm btn-outline-light rounded-pill px-3">
        <i class="bi bi-arrow-left me-1"></i>Volver al panel
    </a>
</div>

<main class="container py-5" style="max-width:820px;">

    <h1 class="fw-bold text-verde-rv mb-1" style="font-size:1.6rem;">
        <i class="bi bi-<?= $esEditar ? 'pencil-square' : 'plus-circle-fill' ?> me-2"></i><?= $titulo ?>
    </h1>
    <p class="text-muted small mb-4">
        <?= $esEditar ? 'Modifica los datos de la experiencia.' : 'Rellena el formulario para añadir una nueva experiencia.' ?>
    </p>

    <?php if (!empty($errores)): ?>
    <div class="alert alert-danger rounded-3 mb-4">
        <p class="fw-bold mb-1"><i class="bi bi-x-circle-fill me-1"></i>Revisa los siguientes campos:</p>
        <ul class="mb-0 ps-3 small">
            <?php foreach ($errores as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" action="<?= $base ?>Admin/<?= $action ?>" id="form-actividad">

        <?php if ($esEditar): ?>
        <input type="hidden" name="id" value="<?= (int)$v('id') ?>">
        <?php endif; ?>

        <!-- ── DATOS GENERALES ── -->
        <div class="section-card">
            <h6><i class="bi bi-info-circle me-1"></i>Datos generales</h6>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la experiencia <span class="text-danger">*</span></label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="<?= htmlspecialchars((string)$v('nombre')) ?>"
                       placeholder="Ej: Cocina de la Sierra" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo de experiencia <span class="text-danger">*</span></label>
                <div class="tipo-radio-group" id="tipo-group">
                    <?php foreach (['taller' => 'Taller', 'ruta' => 'Ruta', 'charla' => 'Charla', 'alojamiento' => 'Alojamiento'] as $val => $lbl): ?>
                    <div>
                        <input type="radio" id="tipo-<?= $val ?>" name="tipo" value="<?= $val ?>"
                               <?= $v('tipo') == $val ? 'checked' : '' ?>>
                        <label for="tipo-<?= $val ?>"><?= $lbl ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="descripcion_general" class="form-label">Descripción general <span class="text-danger">*</span></label>
                <textarea id="descripcion_general" name="descripcion_general" class="form-control" rows="4"
                          placeholder="Descripción visible en la ficha de la experiencia..."><?= htmlspecialchars((string)$v('descripcion_general')) ?></textarea>
            </div>

            <div class="row g-3">
                <div class="col-sm-4">
                    <label for="precio" class="form-label">Precio (€) <span class="text-danger">*</span></label>
                    <input type="number" id="precio" name="precio" class="form-control"
                           min="0" step="0.01" value="<?= htmlspecialchars((string)$v('precio', '0')) ?>">
                </div>
                <div class="col-sm-4">
                    <label for="duracion" class="form-label">Duración (min) <span class="text-danger">*</span></label>
                    <input type="number" id="duracion" name="duracion" class="form-control"
                           min="1" value="<?= htmlspecialchars((string)$v('duracion', '60')) ?>">
                </div>
                <div class="col-sm-4">
                    <label for="estado" class="form-label">Estado</label>
                    <select id="estado" name="estado" class="form-select" id="select-estado">
                        <option value="activa"    <?= $sel('estado','activa') ?>>Activa</option>
                        <option value="cancelada" <?= $sel('estado','cancelada') ?>>Cancelada</option>
                    </select>
                </div>
            </div>

            <!-- Motivo cancelación (visible solo si estado = cancelada) -->
            <div class="mt-3" id="bloque-motivo" style="<?= $v('estado') === 'cancelada' ? '' : 'display:none;' ?>">
                <label for="motivo_cancelacion" class="form-label">Motivo de cancelación</label>
                <input type="text" id="motivo_cancelacion" name="motivo_cancelacion" class="form-control"
                       value="<?= htmlspecialchars((string)$v('motivo_cancelacion')) ?>"
                       placeholder="Explica brevemente el motivo...">
            </div>

            <div class="mt-3">
                <label for="id_organizador" class="form-label">Organizador <span class="text-danger">*</span></label>
                <select id="id_organizador" name="id_organizador" class="form-select">
                    <option value="">— Selecciona un organizador —</option>
                    <?php if ($organizadores): ?>
                        <?php foreach ($organizadores as $org): ?>
                        <option value="<?= $org->id ?>" <?= $v('id_organizador') == $org->id ? 'selected' : '' ?>>
                            <?= htmlspecialchars($org->nombre) ?>
                        </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <!-- ── SESIONES ── -->
        <div class="section-card">
            <h6><i class="bi bi-calendar-event me-1"></i>Sesiones y cupo</h6>
            <p class="text-muted small mb-3">Cada sesión tiene su propia fecha, horario y cupo máximo de participantes.</p>

            <div id="lista-sesiones">
                <?php if (!empty($sesiones)): ?>
                    <?php foreach ($sesiones as $idx => $ses): ?>
                    <div class="sesion-row" data-idx="<?= $idx ?>">
                        <input type="hidden" name="ses_id[]" value="<?= $ses->id ?>">
                        <div class="row g-2 align-items-end">
                            <div class="col-sm-4">
                                <label class="form-label small fw-semibold">Inicio</label>
                                <input type="datetime-local" name="ses_inicio[]" class="form-control form-control-sm"
                                       value="<?= date('Y-m-d\TH:i', strtotime($ses->fecha_hora_inicio)) ?>">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label small fw-semibold">Fin</label>
                                <input type="datetime-local" name="ses_fin[]" class="form-control form-control-sm"
                                       value="<?= date('Y-m-d\TH:i', strtotime($ses->fecha_hora_fin)) ?>">
                            </div>
                            <div class="col-sm-2">
                                <label class="form-label small fw-semibold">Cupo máx.</label>
                                <input type="number" name="ses_cupo[]" class="form-control form-control-sm"
                                       min="1" value="<?= (int)$ses->cupo_max ?>">
                            </div>
                            <div class="col-sm-2 d-flex align-items-end gap-2">
                                <?php if (isset($ses->inscritos) && $ses->inscritos > 0): ?>
                                <span class="badge bg-secondary small" title="Inscritos">
                                    <i class="bi bi-people-fill me-1"></i><?= $ses->inscritos ?>
                                </span>
                                <?php endif; ?>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-sesion"
                                        title="Eliminar sesión">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <button type="button" id="btn-add-sesion"
                    class="btn btn-outline-verde-rv btn-sm mt-3 rounded-pill px-3">
                <i class="bi bi-plus-circle me-1"></i>Añadir sesión
            </button>
        </div>

        <!-- ── TALLER ── -->
        <div class="section-card subtipo-panel" id="panel-taller">
            <h6><i class="bi bi-hand-index-thumb me-1"></i>Datos del taller</h6>
            <div class="mb-3">
                <label for="nivel" class="form-label">Nivel</label>
                <select id="nivel" name="nivel" class="form-select">
                    <option value="iniciacion" <?= $sel('nivel','iniciacion') ?>>Iniciación</option>
                    <option value="medio"      <?= $sel('nivel','medio') ?>>Medio</option>
                    <option value="avanzado"   <?= $sel('nivel','avanzado') ?>>Avanzado</option>
                </select>
            </div>
            <div>
                <label for="materiales_incluidos" class="form-label">Materiales incluidos</label>
                <input type="text" id="materiales_incluidos" name="materiales_incluidos" class="form-control"
                       value="<?= htmlspecialchars((string)$v('materiales_incluidos')) ?>"
                       placeholder="Ej: Delantal, herramientas básicas...">
            </div>
        </div>

        <!-- ── RUTA ── -->
        <div class="section-card subtipo-panel" id="panel-ruta">
            <h6><i class="bi bi-signpost-split me-1"></i>Datos de la ruta</h6>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="dificultad" class="form-label">Dificultad</label>
                    <select id="dificultad" name="dificultad" class="form-select">
                        <option value="baja"  <?= $sel('dificultad','baja') ?>>Baja</option>
                        <option value="media" <?= $sel('dificultad','media') ?>>Media</option>
                        <option value="alta"  <?= $sel('dificultad','alta') ?>>Alta</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <label for="distancia_km" class="form-label">Distancia (km)</label>
                    <input type="number" id="distancia_km" name="distancia_km" class="form-control"
                           min="0" step="0.1" value="<?= htmlspecialchars((string)$v('distancia_km', '0')) ?>">
                </div>
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="punto_inicio" class="form-label">Punto de inicio</label>
                    <input type="text" id="punto_inicio" name="punto_inicio" class="form-control"
                           value="<?= htmlspecialchars((string)$v('punto_inicio')) ?>"
                           placeholder="Ej: Aparcamiento de La Plataforma">
                </div>
                <div class="col-sm-6">
                    <label for="punto_fin" class="form-label">Punto de fin</label>
                    <input type="text" id="punto_fin" name="punto_fin" class="form-control"
                           value="<?= htmlspecialchars((string)$v('punto_fin')) ?>"
                           placeholder="Ej: Laguna Grande de Gredos">
                </div>
            </div>
            <div>
                <label for="recomendaciones" class="form-label">Recomendaciones</label>
                <textarea id="recomendaciones" name="recomendaciones" class="form-control" rows="3"
                          placeholder="Calzado recomendado, nivel de forma física..."><?= htmlspecialchars((string)$v('recomendaciones')) ?></textarea>
            </div>
        </div>

        <!-- ── CHARLA ── -->
        <div class="section-card subtipo-panel" id="panel-charla">
            <h6><i class="bi bi-chat-quote me-1"></i>Datos de la charla</h6>
            <div>
                <label for="tema" class="form-label">Tema de la charla</label>
                <input type="text" id="tema" name="tema" class="form-control"
                       value="<?= htmlspecialchars((string)$v('tema')) ?>"
                       placeholder="Ej: Historia de los oficios tradicionales de Gredos">
            </div>
        </div>

        <!-- ── ALOJAMIENTO ── -->
        <div class="section-card subtipo-panel" id="panel-alojamiento">
            <h6><i class="bi bi-house-heart me-1"></i>Datos del alojamiento</h6>
            <div class="mb-3">
                <label for="tipo_alojamiento" class="form-label">Tipo de alojamiento</label>
                <input type="text" id="tipo_alojamiento" name="tipo_alojamiento" class="form-control"
                       value="<?= htmlspecialchars((string)$v('tipo_alojamiento')) ?>"
                       placeholder="Ej: Casa rural, hotel rural...">
            </div>
            <div class="row g-3 mb-3">
                <div class="col-sm-6">
                    <label for="noches" class="form-label">Número de noches</label>
                    <input type="number" id="noches" name="noches" class="form-control"
                           min="1" value="<?= htmlspecialchars((string)$v('noches', '1')) ?>">
                </div>
                <div class="col-sm-6">
                    <label for="regimen" class="form-label">Régimen</label>
                    <select id="regimen" name="regimen" class="form-select">
                        <option value="solo_alojamiento" <?= $sel('regimen','solo_alojamiento') ?>>Solo alojamiento</option>
                        <option value="desayuno"         <?= $sel('regimen','desayuno') ?>>Con desayuno</option>
                        <option value="media_pension"    <?= $sel('regimen','media_pension') ?>>Media pensión</option>
                        <option value="pension_completa" <?= $sel('regimen','pension_completa') ?>>Pensión completa</option>
                    </select>
                </div>
            </div>
            <div>
                <label for="condiciones" class="form-label">Condiciones especiales</label>
                <textarea id="condiciones" name="condiciones" class="form-control" rows="3"
                          placeholder="Política de cancelación, mascotas, accesibilidad..."><?= htmlspecialchars((string)$v('condiciones')) ?></textarea>
            </div>
        </div>

        <!-- ── BOTONES ── -->
        <div class="d-flex gap-3 justify-content-end pt-2 pb-4">
            <a href="<?= $base ?>Admin/showPanel"
               class="btn btn-outline-secondary rounded-pill px-4">
                Cancelar
            </a>
            <button type="submit" class="btn btn-verde-rv rounded-pill px-5 fw-bold">
                <i class="bi bi-<?= $esEditar ? 'floppy-fill' : 'plus-circle-fill' ?> me-2"></i>
                <?= $esEditar ? 'Guardar cambios' : 'Crear experiencia' ?>
            </button>
        </div>

    </form>
</main>

<!-- Template de fila de sesión (oculto, clonado por JS) -->
<template id="tpl-sesion">
    <div class="sesion-row">
        <input type="hidden" name="ses_id[]" value="0">
        <div class="row g-2 align-items-end">
            <div class="col-sm-4">
                <label class="form-label small fw-semibold">Inicio</label>
                <input type="datetime-local" name="ses_inicio[]" class="form-control form-control-sm">
            </div>
            <div class="col-sm-4">
                <label class="form-label small fw-semibold">Fin</label>
                <input type="datetime-local" name="ses_fin[]" class="form-control form-control-sm">
            </div>
            <div class="col-sm-2">
                <label class="form-label small fw-semibold">Cupo máx.</label>
                <input type="number" name="ses_cupo[]" class="form-control form-control-sm" min="1" value="10">
            </div>
            <div class="col-sm-2 d-flex align-items-end">
                <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar-sesion" title="Eliminar sesión">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
</template>

<script src="<?= $base ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base ?>assets/javascript.js"></script>

<script>
// Mostrar/ocultar motivo cancelación
document.getElementById('estado').addEventListener('change', function () {
    document.getElementById('bloque-motivo').style.display =
        this.value === 'cancelada' ? '' : 'none';
});

// Añadir sesión
document.getElementById('btn-add-sesion').addEventListener('click', function () {
    const tpl  = document.getElementById('tpl-sesion');
    const clone = tpl.content.cloneNode(true);
    document.getElementById('lista-sesiones').appendChild(clone);
    actualizarBotonesSesion();
});

// Eliminar sesión (delegado)
document.getElementById('lista-sesiones').addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-eliminar-sesion');
    if (!btn) return;
    btn.closest('.sesion-row').remove();
});

function actualizarBotonesSesion() {
    // nada extra por ahora
}
</script>
</body>
</html>