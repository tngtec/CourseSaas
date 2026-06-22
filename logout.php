<?php
session_start();       // Inicia la sesión para poder destruirla
session_unset();       // Limpia todas las variables de sesión
session_destroy();     // Elimina la sesión por completo

header("Location: login.php"); // Redirige al formulario de login
exit();
?>