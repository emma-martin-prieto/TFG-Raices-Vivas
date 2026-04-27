window.onload = function () {

  // 1. INICIALIZAR AOS
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 1000,
      once: true,
      offset: 100,
      disableMutationObserver: true
    });
  }

  // 2. CARGA DE CIFRAS
  const loading = document.getElementById("cifras-loading");
  const content = document.getElementById("cifras-content");

  setTimeout(() => {
    if (loading && content) {
      loading.classList.add("d-none");
      content.classList.remove("d-none");
      if (typeof AOS !== 'undefined') AOS.refresh();
    }
  }, 3500);

  // 3. TOOLTIPS Y POPOVERS
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

  var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
  popoverTriggerList.map(el => new bootstrap.Popover(el));

  // 4. FILTRADO DE EXPERIENCIAS
  const filterButtons = document.querySelectorAll('.btn-filter');
  const filterItems   = document.querySelectorAll('.filter-item');

  if (filterButtons.length > 0) {
    filterButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        filterButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        const filterValue = btn.getAttribute('data-filter');
        filterItems.forEach(item => {
          item.style.display = (filterValue === 'all' || item.classList.contains(filterValue)) ? '' : 'none';
        });
        if (typeof AOS !== 'undefined') AOS.refresh();
      });
    });
  }

  // 5. VALIDACIÓN VISUAL DEL FORMULARIO DE INSCRIPCIÓN

  const formulario = document.getElementById('form-inscripcion');
  if (!formulario) return;

  // Muestra un error rojo debajo del campo
  function mostrarError(campo, mensaje) {
    if (!campo) return;

    campo.classList.add('is-invalid-rv');

    const contenedor = campo.closest('.input-group') || campo.closest('.col-md-4') || campo.parentElement;

    // Eliminar mensaje anterior si existía
    const anterior = contenedor.parentElement
      ? contenedor.parentElement.querySelector(`.error-rv[data-campo="${campo.id}"]`)
      : null;
    if (anterior) anterior.remove();

    const msg = document.createElement('div');
    msg.className   = 'error-rv';
    msg.dataset.campo = campo.id;
    msg.innerHTML   = `<i class="bi bi-exclamation-circle-fill me-1"></i>${mensaje}`;
    contenedor.insertAdjacentElement('afterend', msg);

    // Animación shake
    campo.classList.add('shake-rv');
    campo.addEventListener('animationend', () => campo.classList.remove('shake-rv'), { once: true });
  }

  // Limpia el error de un campo concreto
  function limpiarError(campo) {
    if (!campo) return;
    campo.classList.remove('is-invalid-rv');
    const msg = formulario.querySelector(`.error-rv[data-campo="${campo.id}"]`);
    if (msg) msg.remove();
  }

  // Limpia todos los errores
  function limpiarTodos() {
    formulario.querySelectorAll('.is-invalid-rv').forEach(el => el.classList.remove('is-invalid-rv'));
    formulario.querySelectorAll('.error-rv').forEach(el => el.remove());
  }

  // Limpiar error al modificar cada campo
  formulario.querySelectorAll('input, select, textarea').forEach(campo => {
    campo.addEventListener('input',  () => limpiarError(campo));
    campo.addEventListener('change', () => limpiarError(campo));
  });

  // Validación al enviar
  formulario.addEventListener('submit', function (event) {

    limpiarTodos();

    const nombre    = document.getElementById('nombre');
    const apellido1 = document.getElementById('apellido1');
    const email     = document.getElementById('email');
    const fechaNac  = document.getElementById('fecha_nac');
    const telefono  = document.getElementById('telefono');
    const localidad = document.getElementById('id_localidad');

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const tlfRegex   = /^[0-9]{9,11}$/;

    let hayErrores            = false;
    let primerCampoConError   = null;

    function marcar(campo, msg) {
      mostrarError(campo, msg);
      hayErrores = true;
      if (!primerCampoConError) primerCampoConError = campo;
    }

    if (!nombre || nombre.value.trim().length < 2)
      marcar(nombre, "El nombre es obligatorio (mínimo 2 caracteres).");

    if (!apellido1 || apellido1.value.trim().length < 2)
      marcar(apellido1, "El primer apellido es obligatorio.");

    if (!email || !emailRegex.test(email.value.trim()))
      marcar(email, "Introduce un correo electrónico válido.");

    if (!fechaNac || fechaNac.value === "")
      marcar(fechaNac, "La fecha de nacimiento es obligatoria.");

    if (telefono && telefono.value.trim() !== "" && !tlfRegex.test(telefono.value.replace(/\s/g, "")))
      marcar(telefono, "El teléfono debe tener entre 9 y 11 dígitos.");

    if (!localidad || localidad.value === "")
      marcar(localidad, "Selecciona tu provincia.");

    if (hayErrores) {
      event.preventDefault();
      if (primerCampoConError) {
        primerCampoConError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        primerCampoConError.focus();
      }
    }
    // Si no hay errores el formulario se envía al servidor PHP normalmente
  });

};

// 6. BUSCADOR DE INSCRIPCIÓN POR CÓDIGO RV
document.addEventListener('DOMContentLoaded', function () {

    const inputCodigo = document.getElementById('buscar-codigo');
    const btnBuscar   = document.getElementById('btn-buscar-codigo');
    const resultado   = document.getElementById('resultado-codigo');

    if (!inputCodigo || !btnBuscar || !resultado) return;

    const base = resultado.dataset.base || '';

    // Forzar mayúsculas y solo caracteres válidos
    inputCodigo.addEventListener('input', function () {
        this.value = this.value.toUpperCase().replace(/[^A-Z0-9-]/g, '');
    });

    // ── Helpers

    function limpiarResultado() {
        resultado.innerHTML = '';
        resultado.classList.remove('d-none');
    }

    function clonar(id) {
        return document.getElementById(id).content.cloneNode(true);
    }

    function mostrarAlerta(tipo, mensaje, codigoDestacado) {
        limpiarResultado();
        const node = clonar('tpl-alerta-' + tipo);
        node.querySelector('.js-alerta-texto').textContent = mensaje;
        if (codigoDestacado) {
            const codigo = node.querySelector('.js-alerta-codigo');
            const punto  = node.querySelector('.js-alerta-punto');
            if (codigo) { codigo.textContent = codigoDestacado; codigo.classList.remove('d-none'); }
            if (punto)  { punto.classList.remove('d-none'); }
        }
        resultado.appendChild(node);
    }

    function mostrarSpinner() {
        limpiarResultado();
        resultado.appendChild(clonar('tpl-spinner'));
    }

    function badgeClass(tipo) {
        const mapa = {
            taller:      'bg-naranja-rv',
            ruta:        'bg-primary',
            charla:      'bg-success',
            alojamiento: 'bg-info text-dark'
        };
        return mapa[tipo] || 'bg-secondary';
    }

    function mostrarDatos(data) {
        limpiarResultado();

        // Clonar template principal
        const node = clonar('tpl-resultado');

        // Rellenar datos personales
        node.querySelector('.js-nombre-persona').textContent = data.nombre + ' ' + data.priApe;
        node.querySelector('.js-codigo-persona').textContent = data.codigo;
        node.querySelector('.js-email-persona').textContent  = data.email;
        node.querySelector('.js-fecha-persona').textContent  = data.fecha_registro;

        // Rellenar lista de actividades
        const lista = node.querySelector('.js-lista-actividades');

        if (data.actividades && data.actividades.length > 0) {
            data.actividades.forEach(function (act) {
                const cancelada = act.estado === 'cancelada';
                const tplId     = cancelada ? 'tpl-actividad-cancelada' : 'tpl-actividad-normal';
                const li        = clonar(tplId);

                li.querySelector('.js-act-nombre').textContent = act.nombre;
                li.querySelector('.js-act-precio').textContent = parseFloat(act.precio).toFixed(2) + ' €';

                if (!cancelada) {
                    const badge = li.querySelector('.js-act-badge');
                    badge.textContent = act.tipo;
                    badge.classList.add(badgeClass(act.tipo));
                } else {
                    const motivoEl = li.querySelector('.js-act-motivo');
                    if (act.motivo_cancelacion && act.motivo_cancelacion.trim() !== '') {
                        motivoEl.textContent = 'Motivo: ' + act.motivo_cancelacion;
                    } else {
                        motivoEl.remove();
                    }
                }

                lista.appendChild(li);
            });
        } else {
            const liVacio = clonar('tpl-sin-actividades');
            lista.appendChild(liVacio);
        }

        resultado.appendChild(node);
    }

    // ── Función principal de búsqueda 
    function buscar() {
        const codigo = inputCodigo.value.trim().toUpperCase();

        // Código especial de administrador — redirige directamente sin validar longitud
        if (codigo === 'RV-ADMIN') {
            mostrarSpinner();
            window.location.href = base + 'index.php?controller=Admin&action=verificarCodigo&codigo=RV-ADMIN';
            return;
        }

        if (!codigo || codigo.length < 11) {
            mostrarAlerta('warning', 'Por favor, introduce el código que recibiste al inscribirte.');
            return;
        }

        mostrarSpinner();

        fetch(base + 'index.php?controller=Inscripcion&action=buscarCodigo&codigo=' + encodeURIComponent(codigo))
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.redirect) {
                    window.location.href = base + data.redirect;
                } else if (data.error) {
                    mostrarAlerta('danger', data.error, data.codigo_buscado);
                } else {
                    mostrarDatos(data);
                }
            })
            .catch(function () {
                mostrarAlerta('danger', 'Error de conexión. Inténtalo de nuevo.');
            });
    }

    btnBuscar.addEventListener('click', buscar);
    inputCodigo.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') buscar();
    });
});


// 7. CARRITO — BOTÓN RESERVAR Y TOAST
document.addEventListener('DOMContentLoaded', function () {

    const toastEl  = document.getElementById('toastCarrito');
    const toastMsg = document.getElementById('toastMensaje');
    if (!toastEl || !toastMsg) return;

    const toast = new bootstrap.Toast(toastEl, { delay: 3000 });

    function actualizarSpanPlazas(id, libres, total) {
        libres = Math.max(0, libres);
        const ratio    = total > 0 ? libres / total : 1;
        const txt      = libres === 0 ? 'Sin plazas'
                       : 'Quedan ' + libres + ' plaza' + (libres === 1 ? '' : 's');
        const txtModal = libres === 0 ? 'Sin plazas disponibles'
                       : 'Quedan ' + libres + ' de ' + total;
        let cls, clsModal;
        if (libres === 0)       { cls = 'text-danger fw-bold';      clsModal = 'text-danger fw-bold'; }
        else if (ratio <= 0.25) { cls = 'text-danger fw-semibold';  clsModal = 'text-danger'; }
        else if (ratio <= 0.5)  { cls = 'text-warning fw-semibold'; clsModal = 'text-warning'; }
        else                    { cls = 'text-muted';                clsModal = 'text-success'; }

        const spanCard = document.getElementById('plazas-' + id);
        if (spanCard) {
            spanCard.className   = 'small ' + cls;
            spanCard.innerHTML   = '<i class="bi bi-people-fill me-1"></i>' + txt;
        }
        const spanModal = document.getElementById('plazas-modal-' + id);
        if (spanModal) {
            spanModal.className  = clsModal;
            spanModal.textContent = txtModal;
        }
        const btnRes = document.querySelector('.btn-reservar[data-id="' + id + '"]');
        if (btnRes) {
            btnRes.disabled = libres === 0;
            if (libres === 0) btnRes.title = 'No quedan plazas disponibles';
        }
    }

    document.querySelectorAll('.btn-reservar').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const base = this.dataset.base;

            fetch(base + 'index.php?controller=Carrito&action=aniadir&id=' + id, {
                credentials: 'same-origin'
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                toastEl.classList.remove('bg-danger', 'bg-success');
                toastEl.classList.add(data.ok ? 'bg-success' : 'bg-danger');
                toastMsg.textContent = data.mensaje;
                toast.show();
                if (data.ok && data.plazas_libres !== null && data.plazas_libres !== undefined) {
                    actualizarSpanPlazas(data.id_actividad, data.plazas_libres, data.cupo_max);
                }
            });
        });
    });
});

// 8. PANEL ADMIN — tooltips y modal de confirmación de borrado
document.addEventListener('DOMContentLoaded', function () {

    // Tooltips (solo en páginas que los usen)
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(el) {
        new bootstrap.Tooltip(el);
    });

    // Modal de confirmación de borrado de actividad
    document.querySelectorAll('.btn-eliminar').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var nombre = this.dataset.nombre;
            var id     = this.dataset.id;
            var modalNombre = document.getElementById('modal-nombre-act');
            var modalInput  = document.getElementById('input-id-eliminar');
            var modalEl     = document.getElementById('modalEliminar');
            if (modalNombre) modalNombre.textContent = nombre;
            if (modalInput)  modalInput.value        = id;
            if (modalEl)     new bootstrap.Modal(modalEl).show();
        });
    });
});


// 9. FORMULARIO ADMIN — mostrar panel de subtipo según tipo seleccionado
document.addEventListener('DOMContentLoaded', function () {
 
    // Si no hay radios de tipo, esta página no es el formulario admin → salir
    var radios = document.querySelectorAll('input[name="tipo"]');
    if (!radios.length) return;
 
    function mostrarPanel(tipo) {
        radios.forEach(function (radio) {
            var panel = document.getElementById('panel-' + radio.value);
            if (!panel) return;
            panel.classList.toggle('activo', radio.value === tipo);
        });
    }
 
    radios.forEach(function (radio) {
        radio.addEventListener('change', function () {
            mostrarPanel(this.value);
        });
    });
 
    var seleccionado = document.querySelector('input[name="tipo"]:checked');
    if (seleccionado) mostrarPanel(seleccionado.value);
});