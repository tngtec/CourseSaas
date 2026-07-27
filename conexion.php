<?php
// Conexión central a la base de datos (Aiven Cloud)
$host = "mysql-3aa764ad-josegregoriraveloinfante-e24b.l.aivencloud.com";
$usuario = "avnadmin";
$contrasena = "18169247"; 
$base = "defaultdb";
$puerto = 21389;

$conn = new mysqli($host, $usuario, $contrasena, $base, $puerto);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>