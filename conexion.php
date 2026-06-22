
<?php
//conexión central a la base de datos
$host = "localhost";  // El servidor de la base de datos
$usuario = "root";   // Nombre de usuario con el que se accede
$contrasena = "";   // Contraseña del usuario

$base = "base1";   // <--- CAMBIADO AQUÍ: De 'mi_base' a 'base1'


$conn = new mysqli($host, $usuario, $contrasena, $base);
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
?>