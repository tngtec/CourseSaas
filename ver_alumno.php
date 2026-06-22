<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Control de acceso
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Validar que se reciba la cédula
if (!isset($_GET['cedula']) || empty($_GET['cedula'])) {
    header("Location: alumnos.php");
    exit();
}

$cedula = $_GET['cedula'];

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// Escapar para evitar inyecciones SQL sencillas
$cedula = mysqli_real_escape_string($conexion, $cedula);

// Consulta del alumno específico
$query = "SELECT cedula, nombre, mail, codigocurso FROM alumnos WHERE cedula = '$cedula'";
$resultado = mysqli_query($conexion, $query);

if (mysqli_num_rows($resultado) === 0) {
    echo "<script>alert('El alumno no existe.'); window.location.href='alumnos.php';</script>";
    exit();
}

$alumno = mysqli_fetch_array($resultado);

// Conversión del nombre de curso
$nombreCurso = "";
switch ($alumno['codigocurso']) {
    case 1: $nombreCurso = "PHP"; break;
    case 2: $nombreCurso = "ASP"; break;
    case 3: $nombreCurso = "JSP"; break;
    default: $nombreCurso = "No asignado (" . $alumno['codigocurso'] . ")"; break;
}

$iniciales = strtoupper(substr($alumno['nombre'], 0, 2));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Ficha del Alumno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Estilos específicos para la ficha de perfil */
        .profile-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            max-width: 600px;
            margin: 40px auto;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .profile-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            background-color: #ffffff;
            color: #2563eb;
            font-size: 32px;
            font-weight: 700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .profile-header h2 { margin: 0; font-size: 24px; font-weight: 600; }
        .profile-header p { margin: 5px 0 0 0; color: #bfdbfe; font-size: 14px; }
        
        .profile-body { padding: 30px; }
        .info-group {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-group:last-child { border-bottom: none; }
        .info-icon {
            width: 40px;
            height: 40px;
            background: #eff6ff;
            color: #3b82f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-right: 15px;
        }
        .info-content { flex: 1; }
        .info-label { font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 600; letter-spacing: 0.5px; }
        .info-value { font-size: 16px; color: #1e293b; font-weight: 500; margin-top: 2px; }
        
        .profile-footer {
            background: #f8fafc;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            border-top: 1px solid #e2e8f0;
        }
        .btn-back {
            background: #64748b;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .btn-back:hover { background: #475569; }
        .btn-edit-profile {
            background: #2563eb;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.2s;
        }
        .btn-edit-profile:hover { background: #1d4ed8; }
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
            <div style="font-weight: 500; color: #64748b;">
                Gestión de Alumnos &gt; Ficha del Estudiante
            </div>
            <div class="user-profile">
                <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                <span><?php echo $_SESSION['usuario'] ?? 'Administrador'; ?></span>
            </div>
        </header>

        <main class="content">
            
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar"><?php echo $iniciales; ?></div>
                    <h2><?php echo htmlspecialchars($alumno['nombre']); ?></h2>
                    <p>Estudiante del Sistema</p>
                </div>
                
                <div class="profile-body">
                    <div class="info-group">
                        <div class="info-icon"><i class="fa-solid fa-id-card"></i></div>
                        <div class="info-content">
                            <div class="info-label">Cédula de Identidad</div>
                            <div class="info-value"><?php echo htmlspecialchars($alumno['cedula']); ?></div>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="info-content">
                            <div class="info-label">Correo Electrónico</div>
                            <div class="info-value"><?php echo htmlspecialchars($alumno['mail']); ?></div>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-icon"><i class="fa-solid fa-book-bookmark"></i></div>
                        <div class="info-content">
                            <div class="info-label">Curso Inscrito</div>
                            <div class="info-value"><?php echo htmlspecialchars($nombreCurso); ?></div>
                        </div>
                    </div>

                    <div class="info-group">
                        <div class="info-icon"><i class="fa-solid fa-circle-check"></i></div>
                        <div class="info-content">
                            <div class="info-label">Estado del Registro</div>
                            <div class="info-value" style="color: #10b981;">Inscrito / Activo</div>
                        </div>
                    </div>
                </div>

                <div class="profile-footer">
                    <a href="alumnos.php" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Volver a la lista
                    </a>
                    <a href="javascript:void(0)" class="btn-edit-profile" onclick="window.location.href='alumnos.php?editar=<?php echo $alumno['cedula']; ?>'">
                        <i class="fa-solid fa-user-pen"></i> Modificar Datos
                    </a>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
<?php mysqli_close($conexion); ?>