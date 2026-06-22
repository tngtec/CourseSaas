

    document.getElementById('myForm').addEventListener('submit', function (e) {
      let valid = true;
      const usuario = document.getElementById('usuario');
      const contrasena = document.getElementById('contrasena');
      
      [usuario, contrasena].forEach(input => input.classList.remove('is-invalid'));

      if (usuario.value.trim() === '' || !usuario.value.includes('@')) {
        usuario.classList.add('is-invalid');
        valid = false;
      }

      if (contrasena.value.trim().length < 6) {
        contrasena.classList.add('is-invalid');
        valid = false;
      }

      if (!valid) e.preventDefault();
    });

    document.getElementById("contrasena").addEventListener("input", mostrarIcono);

    function togglePassword() {
      const input = document.getElementById("contrasena");
      const icon = document.getElementById("toggleIcon");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
      }
    }

    function mostrarIcono() {
      const input = document.getElementById("contrasena");
      const icon = document.getElementById("toggleIcon");
      icon.style.display = input.value.length > 0 ? "block" : "none";
    }






