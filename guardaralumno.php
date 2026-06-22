<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Control de acceso: Si la sesión 'usuario' no existe, directo al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// Captura y sanitización de los datos enviados desde el formulario
$cedula      = filter_var($_REQUEST['cedula'] ?? '', FILTER_SANITIZE_NUMBER_INT);
$nombre      = filter_var($_REQUEST['nombre'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
$mail        = filter_var($_REQUEST['mail'] ?? '', FILTER_SANITIZE_EMAIL);
$codigocurso = filter_var($_REQUEST['codigocurso'] ?? '', FILTER_SANITIZE_NUMBER_INT);

// 1. Validación: Verificar que ningún campo obligatorio esté vacío
if (empty($nombre) || empty($cedula) || empty($mail) || empty($codigocurso)) {
    die("Error: Todos los campos (Nombre, Cédula, Correo y Curso) son estrictamente obligatorios.<br>");
}

// 2. Validación: Que el nombre no contenga únicamente números
if (ctype_digit($nombre)) {
    die("Error: El campo nombre no puede contener únicamente números.<br>");
}

// 3. Validación: Formato de correo electrónico válido
if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    die("Error: El formato del correo electrónico ingresado no es válido.<br>");
}

// Preparar la consulta SQL de inserción segura (PreparedStatement)
$stmt = $conexion->prepare("INSERT INTO alumnos (cedula, nombre, mail, codigocurso) VALUES (?, ?, ?, ?)");

// Vincular parámetros: 
// i = entero (cedula)
// s = string (nombre)
// s = string (mail)
// i = entero (codigocurso)
$stmt->bind_param("issi", $cedula, $nombre, $mail, $codigocurso);

// Ejecutar la consulta en la base de datos
if ($stmt->execute()) {
    // Cerramos la sentencia y la conexión antes de salir
    $stmt->close();
    mysqli_close($conexion);
    
    // Redirección directa al listado de alumnos con aviso de éxito
    header("Location: alumnos.php?registro=exito");
    exit();
} else {
    echo "Error al registrar en la base de datos: " . $stmt->error;
    $stmt->close();
    mysqli_close($conexion);
}
?>