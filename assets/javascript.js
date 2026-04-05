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