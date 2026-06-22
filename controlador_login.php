
<?php
session_start();
require_once("conexion.php");

if (!empty($_POST["btningresar"])){
    if ((!empty($_POST["usuario"])) and (!empty($_POST["contrasena"]))) {
        $usuario=$_POST["usuario"];
        $contrasena=$_POST["contrasena"];
        
        // CORRECCIÓN: Tabla 'alumnos', columnas 'mail' y 'cedula'
        $sql=$conn->query("select * from alumnos where mail='$usuario' and cedula='$contrasena'");
        
        if($datos=$sql->fetch_object()){
            // CORRECCIÓN: Ajustamos al nombre real de los campos en tu BD
            $_SESSION["usuario"] = $datos->mail; 
            $_SESSION["nombre"] = $datos->nombre; 
            
            header("location:inicio.php");
            exit(); // Recomendado para detener la ejecución tras redirigir
        } else {
            echo "Usuario o contraseña incorrectos";
        }
    }
}
?>
