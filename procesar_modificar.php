<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Validar seguridad de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// 2. Verificar que los datos lleguen por el método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

    // Recoger y limpiar variables básicas
    $cedula_vieja = trim($_POST['cedula_vieja']);
    $cedula_nueva = trim($_POST['cedula_nueva']);
    $nombre       = trim($_POST['nombre']);
    $mail         = trim($_POST['mail']);
    $codigocurso  = intval($_POST['codigocurso']);

    // 3. Validaciones básicas antes de guardar
    if (empty($cedula_vieja) || empty($cedula_nueva) || empty($nombre) || empty($mail) || empty($codigocurso)) {
        echo "<script>alert('Todos los campos son obligatorios.'); window.history.back();</script>";
        exit();
    }

    // 4. Si el usuario cambió la cédula, verificar primero que la NUEVA cédula no pertenezca ya a OTRO estudiante
    if ($cedula_vieja !== $cedula_nueva) {
        $stmt_check = $conexion->prepare("SELECT cedula FROM alumnos WHERE cedula = ?");
        $stmt_check->bind_param("s", $cedula_nueva);
        $stmt_check->execute();
        $resultado_check = $stmt_check->get_result();

        if ($resultado_check->num_rows > 0) {
            echo "<script>alert('Error: La nueva cédula ya se encuentra asignada a otro estudiante.'); window.history.back();</script>";
            $stmt_check->close();
            mysqli_close($conexion);
            exit();
        }
        $stmt_check->close();
    }

    // 5. Preparar la consulta de actualización segura (UPDATE)
    $stmt_update = $conexion->prepare("UPDATE alumnos SET cedula = ?, nombre = ?, mail = ?, codigocurso = ? WHERE cedula = ?");
    
    // Pasamos los parámetros en orden: cedula_nueva (s), nombre (s), mail (s), codigocurso (i), cedula_vieja (s)
    $stmt_update->bind_param("sssis", $cedula_nueva, $nombre, $mail, $codigocurso, $cedula_vieja);

    // 6. Ejecutar y comprobar si fue exitoso
    if ($stmt_update->execute()) {
        // Redirección limpia si todo sale bien
        echo "<script>alert('¡Alumno actualizado correctamente!'); window.location.href='alumnos.php';</script>";
    } else {
        // Mostrar error en caso de fallo técnico
        echo "<script>alert('Hubo un error al intentar actualizar los datos: " . $stmt_update->error . "'); window.history.back();</script>";
    }

    // Cerrar flujos
    $stmt_update->close();
    mysqli_close($conexion);

} else {
    // Si intentan entrar directo al archivo sin pasar por el formulario
    header("Location: alumnos.php");
    exit();
}
?>