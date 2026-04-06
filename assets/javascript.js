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

    // ── Helpers para crear elementos DOM

    function crearElemento(tag, clases, texto) {
        const el = document.createElement(tag);
        if (clases) el.className = clases;
        if (texto)  el.textContent = texto;
        return el;
    }

    function limpiarResultado() {
        while (resultado.firstChild) {
            resultado.removeChild(resultado.firstChild);
        }
        resultado.classList.remove('d-none');
    }

    function mostrarAlerta(tipo, mensaje) {
        limpiarResultado();
        const alert = crearElemento('div', `alert alert-${tipo} rounded-3 mb-0 d-flex align-items-center gap-2`);
        const icono = document.createElement('i');
        icono.className = tipo === 'warning'
            ? 'bi bi-exclamation-triangle-fill'
            : 'bi bi-x-circle-fill';
        const texto = crearElemento('span', null, mensaje);
        alert.appendChild(icono);
        alert.appendChild(texto);
        resultado.appendChild(alert);
    }

    function mostrarSpinner() {
        limpiarResultado();
        const wrap   = crearElemento('div', 'py-2 d-flex align-items-center gap-2');
        const spin   = crearElemento('div', 'spinner-border spinner-border-sm text-verde-rv');
        const texto  = crearElemento('span', 'text-muted small', 'Buscando...');
        wrap.appendChild(spin);
        wrap.appendChild(texto);
        resultado.appendChild(wrap);
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

        const wrapper = crearElemento('div', 'border rounded-4 overflow-hidden');

        // ── Cabecera verde ──
        const cabecera = crearElemento('div', 'bg-verde-rv text-white px-4 py-3 d-flex justify-content-between align-items-center');

        const infoPersona = crearElemento('div');
        const labelEncontrado = crearElemento('p', 'mb-0 small opacity-75', 'Inscripción encontrada');
        const nombrePersona   = crearElemento('h6', 'mb-0 fw-bold', data.nombre + ' ' + data.priApe);
        infoPersona.appendChild(labelEncontrado);
        infoPersona.appendChild(nombrePersona);

        const badgeCodigo = crearElemento('span', 'badge bg-naranja-rv fs-6', data.codigo);
        badgeCodigo.style.letterSpacing = '2px';
        badgeCodigo.style.fontFamily    = "'Courier New', monospace";

        cabecera.appendChild(infoPersona);
        cabecera.appendChild(badgeCodigo);

        // ── Info email y fecha ──
        const infoExtra = crearElemento('div', 'px-4 py-3 bg-white border-bottom');
        const pInfo     = crearElemento('p', 'mb-0 small text-muted');

        const iconoEmail = document.createElement('i');
        iconoEmail.className = 'bi bi-envelope me-1';
        pInfo.appendChild(iconoEmail);
        pInfo.appendChild(document.createTextNode(data.email + ' · '));

        const iconoCal = document.createElement('i');
        iconoCal.className = 'bi bi-calendar me-1';
        pInfo.appendChild(iconoCal);
        pInfo.appendChild(document.createTextNode('Registrado el ' + data.fecha_registro));

        infoExtra.appendChild(pInfo);

        // ── Lista de actividades ──
        const secActividades = crearElemento('div', 'bg-white');
        const tituloActs     = crearElemento('p', 'px-4 pt-3 mb-1 small fw-bold text-verde-rv text-uppercase', 'Actividades reservadas');
        const iconoBag = document.createElement('i');
        iconoBag.className = 'bi bi-bag-check me-1';
        tituloActs.prepend(iconoBag);

        const listaActs = crearElemento('ul', 'list-group list-group-flush');

        if (data.actividades && data.actividades.length > 0) {
            data.actividades.forEach(function (act) {
                const li     = crearElemento('li', 'list-group-item d-flex justify-content-between align-items-center py-2 px-3');
                const divIzq = crearElemento('div');
                const nombre = crearElemento('span', 'fw-semibold small', act.nombre);
                const badge  = crearElemento('span', 'badge ms-2 ' + badgeClass(act.tipo), act.tipo);
                divIzq.appendChild(nombre);
                divIzq.appendChild(badge);

                const precio = crearElemento('span', 'fw-bold text-verde-rv small',
                    parseFloat(act.precio).toFixed(2) + ' €');

                li.appendChild(divIzq);
                li.appendChild(precio);
                listaActs.appendChild(li);
            });
        } else {
            const li = crearElemento('li', 'list-group-item text-muted small py-2 px-3',
                'Sin actividades registradas.');
            listaActs.appendChild(li);
        }

        secActividades.appendChild(tituloActs);
        secActividades.appendChild(listaActs);

        // ── Montar todo ──
        wrapper.appendChild(cabecera);
        wrapper.appendChild(infoExtra);
        wrapper.appendChild(secActividades);
        resultado.appendChild(wrapper);
    }

    // ── Función principal de búsqueda 
    function buscar() {
        const codigo = inputCodigo.value.trim().toUpperCase();

        if (!codigo || codigo.length < 4) {
            mostrarAlerta('warning', 'Introduce un código válido (ej: RV-AB12).');
            return;
        }

        mostrarSpinner();

        fetch(base + 'index.php?controller=Inscripcion&action=buscarCodigo&codigo=' + encodeURIComponent(codigo))
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.error) {
                    mostrarAlerta('danger', data.error);
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

    document.querySelectorAll('.btn-reservar').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const id   = this.dataset.id;
            const base = this.dataset.base;

            fetch(base + 'index.php?controller=Carrito&action=aniadir&id=' + id, {
                credentials: 'same-origin'
            })
            .then(r => r.json())
            .then(data => {
                toastEl.classList.remove('bg-danger', 'bg-success');
                toastEl.classList.add(data.ok ? 'bg-success' : 'bg-danger');
                toastMsg.textContent = data.mensaje;
                toast.show();
            });
        });
    });

});