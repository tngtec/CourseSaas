
   // Escuchamos el evento 'submit' (cuando se presiona el botón de enviar) en el formulario  
    document.getElementById('myForm').addEventListener('submit', function (e) {
      let valid = true;  // Variable para controlar si el formulario está correcto o no
      const usuario = document.getElementById('usuario'); // Obtenemos el campo de usuario
      const contrasena = document.getElementById('contrasena'); // Obtenemos el campo de contraseña
      // Quitamos la clase 'is-invalid' de ambos campos para limpiar errores anteriores
      [usuario, contrasena].forEach(input => input.classList.remove('is-invalid'));
       
      // Validamos el usuario: si está vacío o no tiene el símbolo '@'
      if (usuario.value.trim() === '' || !usuario.value.includes('@')) {
        usuario.classList.add('is-invalid');  // Ponemos el borde rojo al campo
        valid = false;  // Marcamos que el formulario no es válido
      }
       // Validamos la contraseña: si tiene menos de 6 caracteres
      if (contrasena.value.trim().length < 6) {
        contrasena.classList.add('is-invalid');// Ponemos el borde rojo al campo
        valid = false; // Marcamos que el formulario no es válido
      }
      // Si 'valid' es false (hay errores), evitamos que el formulario se envíe
      if (!valid) e.preventDefault();
    });
     // Detectamos cuando el usuario escribe en el campo contraseña para mostrar el icono
    document.getElementById("contrasena").addEventListener("input", mostrarIcono);
   // Función para cambiar la visibilidad de la contraseña (ver/ocultar)
    function togglePassword() {
      const input = document.getElementById("contrasena");
      const icon = document.getElementById("toggleIcon");
    // Si el tipo es 'password', lo cambiamos a 'text' para ver los caracteres
      if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");  // Cambiamos el icono a ojo cerrado
        icon.classList.add("fa-eye-slash");
      } else {
        // Si el tipo es 'text', lo volvemos a 'password' para ocultar
        input.type = "password";
        icon.classList.remove("fa-eye-slash"); // Cambiamos el icono a ojo abierto
        icon.classList.add("fa-eye");
      }
    }
    // Función para mostrar el icono del ojo solo cuando el campo tiene texto
    function mostrarIcono() {
      const input = document.getElementById("contrasena");
      const icon = document.getElementById("toggleIcon");
      icon.style.display = input.value.length > 0 ? "block" : "none";
    }






