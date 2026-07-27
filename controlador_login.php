
<?php
// Inicia la sesión para poder guardar los datos del usuario logueado en variables globales
session_start();
// Incluye el archivo de conexión a la base de datos para poder realizar consultas
require_once("conexion.php");

// 1. Verificamos que el botón del formulario (btningresar) haya sido presionado
if (!empty($_POST["btningresar"])){
     // 2. Comprobamos que los campos 'usuario' y 'contrasena' no estén vacíos
      if ((!empty($_POST["usuario"])) and (!empty($_POST["contrasena"]))) {
        
        // Asignamos los valores recibidos del formulario a variables locales
        $usuario=$_POST["usuario"];
        $contrasena=$_POST["contrasena"];
        
        // 3. Realizamos la consulta SQL a la base de datos
        // Buscamos si existe un registro donde el mail coincida con el usuario y la cédula con la contraseña

        // CORRECCIÓN: Tabla 'alumnos', columnas 'mail' y 'cedula'
        $sql=$conn->query("select * from usuarios where mail='$usuario' and cedula='$contrasena'");

        // 4. Si la consulta devuelve un resultado (fetch_object), significa que el usuario es correcto
        if($datos=$sql->fetch_object()){
            // CORRECCIÓN: Ajustamos al nombre real de los campos en tu BD
            // Guardamos la información del usuario en la sesión para usarla en otras páginas
            $_SESSION["usuario"] = $datos->mail; 
            $_SESSION["nombre"] = $datos->nombre; 
            
            // Redirigimos al usuario a la página principal de tu sistema
            header("location:inicio.php");
            // Detenemos la ejecución del script para asegurar que la redirección ocurra
            exit(); // Recomendado para detener la ejecución tras redirigir
        } else {
          // Si no se encontraron coincidencias en la base de datos, mostramos este error 
          echo "Usuario o contraseña incorrectos";
        }
    }
}
?>
