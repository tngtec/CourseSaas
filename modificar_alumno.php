

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validación de sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si llegó la cédula por URL
if (!isset($_GET['cedula']) || empty($_GET['cedula'])) {
    header("Location: alumnos.php");
    exit();
}

$cedula_buscar = $_GET['cedula'];

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// Consultar los datos actuales del alumno de forma segura
$stmt = $conexion->prepare("SELECT cedula, nombre, mail, codigocurso FROM alumnos WHERE cedula = ?");
$stmt->bind_param("s", $cedula_buscar); // Se usa "s" si la cédula almacena texto o "i" si es entero estricto
$stmt->execute();
$resultado = $stmt->get_result();

// Si el alumno existe, guardamos sus datos
if ($reg = $resultado->fetch_assoc()) {
    $nombre = $reg['nombre'];
    $cedula = $reg['cedula'];
    $mail = $reg['mail'];
    $curso_actual = $reg['codigocurso'];
} else {
    echo "<script>alert('El alumno no existe.'); window.location.href='alumnos.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Modificar Alumno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Estilos para el formulario estilizado */
        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 30px;
            max-width: 600px;
            margin: 20px auto;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
            box-sizing: border-box;
        }
        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 30px;
        }
        .btn-save {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
        }
        .btn-save:hover { background-color: #1d4ed8; }
        .btn-cancel {
            background-color: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
        }
        .btn-cancel:hover { background-color: #e2e8f0; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div>
            <div class="brand">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>CourseSaas</span>
            </div>
            <ul class="menu">
                <li class="menu-item"><a href="inicio.php"><i class="fa-solid fa-house"></i> Home</a></li>
                <li class="menu-item active"><a href="alumnos.php"><i class="fa-solid fa-users"></i> Alumnos</a></li>
                <li class="menu-item"><a href="cursos.php"><i class="fa-solid fa-book"></i> Cursos</a></li>
                <li class="menu-item"><a href="reportes.php"><i class="fa-solid fa-chart-pie"></i> Reportes</a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
    </aside>

    <div class="main-container">
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 10px; color: #64748b;">
                <a href="alumnos.php" style="text-decoration: none; color: #3b82f6;">Gestión de Alumnos</a> 
                <i class="fa-solid fa-chevron-right" style="font-size: 12px;"></i> 
                <span>Modificar Estudiante</span>
            </div>
            <div class="user-profile">
                <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                <span><?php echo $_SESSION['usuario'] ?? 'Administrador'; ?></span>
            </div>
        </header>

        <main class="content">
            <div class="form-container">
                <h2 style="margin-bottom: 25px; color: #1e293b;"><i class="fa-solid fa-user-pen" style="color: #3b82f6; margin-right: 10px;"></i>Modificar Información del Alumno</h2>
                
                <form action="procesar_modificar.php" method="post">
                    
                    <input type="hidden" name="cedula_vieja" value="<?php echo $cedula; ?>">

                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="cedula">Cédula de Identidad</label>
                        <input type="text" id="cedula" name="cedula_nueva" class="form-control" value="<?php echo htmlspecialchars($cedula); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="mail">Correo Electrónico</label>
                        <input type="email" id="mail" name="mail" class="form-control" value="<?php echo htmlspecialchars($mail); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="curso">Curso / Especialidad</label>
                        <select id="curso" name="codigocurso" class="form-control" required>
                            <option value="1" <?php if($curso_actual == 1) echo 'selected'; ?>>PHP</option>
                            <option value="2" <?php if($curso_actual == 2) echo 'selected'; ?>>ASP</option>
                            <option value="3" <?php if($curso_actual == 3) echo 'selected'; ?>>JSP</option>
                        </select>
                    </div>

                    <div class="btn-group">
                        <a href="alumnos.php" class="btn-cancel">Cancelar</a>
                        <button type="submit" class="btn-save"><i class="fa-solid fa-floppy-disk"></i> Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>