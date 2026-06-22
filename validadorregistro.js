

  document.getElementById("correo").addEventListener("input", function () {
    const correo = this;
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   

    if (correoRegex.test(correo.value.trim())) {
      correo.classList.remove("is-invalid");
    } else {
      correo.classList.add("is-invalid");
    }
  });

  document.getElementById("clave").addEventListener("input", function () {
    const clave = this;
    const icono = document.getElementById("iconoClave");
    icono.style.display = clave.value.length > 0 ? "block" : "none";

    if (clave.value.length >= 6) {
      clave.classList.remove("is-invalid");
    } else {
      clave.classList.add("is-invalid");
    }
  });

  function toggleClave() {
    const input = document.getElementById("clave");
    const icono = document.getElementById("iconoClave");

    if (input.type === "password") {
      input.type = "text";
      icono.classList.remove("fa-eye");
      icono.classList.add("fa-eye-slash");
    } else {
      input.type = "password";
      icono.classList.remove("fa-eye-slash");
      icono.classList.add("fa-eye");
    }
  }

  // Validación final al enviar
  document.getElementById("registroForm").addEventListener("submit", function (e) {
    const correo = document.getElementById("correo");
    const clave = document.getElementById("clave");
     const nombre = document.getElementById('nombre');
    const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let valido = true;

    if (!correoRegex.test(correo.value.trim())) {
      correo.classList.add("is-invalid");
      valido = false;
    }

    if (clave.value.length < 6) {
      clave.classList.add("is-invalid");
      valido = false;
    }

    if (nombre.value.trim() === '' ) {
        nombre.classList.add('is-invalid');
        valido = false;
      }

    if (!valido) e.preventDefault();
  });
