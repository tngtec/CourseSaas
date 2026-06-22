<?php
// 1. Inicializar la sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Desvincular todas las variables de sesión
$_SESSION = array();

// 3. Si se desea destruir la cookie de sesión, se borra también
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Destruir la sesión completamente
session_destroy();

// 5. Redirigir al usuario al login
header("Location: login.php");
exit();
?>