<?php
// Lógica que guarda al nuevo usuario en la base de datos:
require 'conexion.php';

// 1. Recibir los datos del formulario HTML
$nombre  = $_POST['nombre'];
$correo  = $_POST['correo'];
$cedula  = $_POST['clave']; // Asegúrate de que en tu HTML el input de la cédula tenga name="cedula"

// Opcional: Si deseas encriptar la cédula como contraseña, descomenta la siguiente línea:
// $cedula_encriptada = password_hash($cedula, PASSWORD_DEFAULT);

// 2. Preparar la consulta con los nombres exactos de tu BD (nombre, mail, cedula)
$sql = "INSERT INTO alumnos (nombre, mail, cedula) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

// 3. Vincular las variables reales que definimos arriba
// Si decides encriptar, cambia $cedula por $cedula_encriptada
$stmt->bind_param("sss", $nombre, $correo, $cedula); 

// 4. Ejecutar la consulta (¡Faltaba este paso!)
$stmt->execute();

// 5. Verificar si se insertó el registro
if ($stmt->affected_rows > 0) {
    header("Location: login.php");
    exit(); // Detiene el script para asegurar la redirección limpia
} else {
    echo "<div class='alert alert-danger text-center mt-4'>Error al registrar.</div>";
}

$stmt->close();
$conn->close();
?>