<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Validar seguridad de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// 2. Verificar que vengan las variables correctas por URL (GET)
if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['cedula'])) {
    
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");
    
    $cedula_eliminar = trim($_GET['cedula']);

    if (!empty($cedula_eliminar)) {
        
        // 3. Consulta de eliminación segura mediante Prepared Statements
        $stmt = $conexion->prepare("DELETE FROM alumnos WHERE cedula = ?");
        $stmt->bind_param("s", $cedula_eliminar);

        // 4. Ejecutar y evaluar el resultado
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                // Éxito: Registro borrado
                echo "<script>alert('¡Estudiante eliminado exitosamente del sistema!'); window.location.href='alumnos.php';</script>";
            } else {
                // La cédula no existía o ya se había borrado
                echo "<script>alert('No se encontró ningún alumno con esa cédula.'); window.location.href='alumnos.php';</script>";
            }
        } else {
            // Error en la base de datos
            echo "<script>alert('Error técnico al intentar eliminar: " . $stmt->error . "'); window.location.href='alumnos.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('La cédula proporcionada está vacía.'); window.location.href='alumnos.php';</script>";
    }

    mysqli_close($conexion);
} else {
    // Si acceden de forma directa sin pasar los parámetros correspondientes
    header("Location: alumnos.php");
    exit();
}
?>