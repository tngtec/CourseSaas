<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la variable de sesión 'usuario' no existe, lo manda directo al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Registrar Alumno</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    <style>
        /* Contenedor flexible para centrar el formulario en la pantalla */
        .center-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px); /* Resta el espacio aproximado de la topbar */
            padding: 20px;
            box-sizing: border-box;
        }

        /* Caja del formulario sencilla y limpia */
        .form-box {
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 520px; /* Ancho ideal para que no se vea estirado */
            box-sizing: border-box;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #334155;
            font-size: 14px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
            background-color: #fff;
            color: #333;
            transition: border-color 0.2s;
        }

        .form-group input:focus, .form-group select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn-guardar {
            background-color: #2563eb;
            color: white;
            padding: 11px 22px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-guardar:hover {
            background-color: #1d4ed8;
        }

        .btn-cancelar {
            background-color: #f1f5f9;
            color: #475569;
            padding: 11px 22px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            text-align: center;
            box-sizing: border-box;
            flex-grow: 1;
        }

        .btn-cancelar:hover {
            background-color: #e2e8f0;
        }
    </style>
</head>
<body class="bg-[#f4f6f9] text-slate-800">

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
            <div style="font-size: 14px; color: #64748b;">
                <a href="alumnos.php" style="color: inherit; text-decoration: none;">Gestión de Alumnos</a>
                <span style="margin: 0 5px;">&gt;</span>
                <span style="color: #1e293b; font-weight: 500;">Nuevo Registro</span>
            </div>
            <div class="user-profile">
                <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                <span><?php echo $_SESSION['usuario'] ?? 'Administrador'; ?></span>
            </div>
        </header>

        <div class="center-wrapper">
            
            <div class="form-box">
                <div style="margin-bottom: 15px;">
                    <a href="alumnos.php" style="text-decoration: none; color: #64748b; font-size: 13px; display: inline-flex; align-items: center; gap: 5px;">
                        <i class="fa-solid fa-arrow-left"></i> Volver a la lista
                    </a>
                </div>

                <h2 style="margin: 0 0 6px 0; font-size: 20px; color: #0f172a; font-weight: 700;">Registrar Nuevo Alumno</h2>
                <p style="margin: 0 0 24px 0; font-size: 13px; color: #64748b;">Ingresa los datos para la inscripción.</p>

                <form action="guardaralumno.php" method="POST">
                    
                    <div class="form-group">
                        <label for="nombre">Nombre Completo</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Ej. Juan Pérez" required>
                    </div>

                    <div class="form-group">
                        <label for="cedula">Cédula de Identidad</label>
                        <input type="number" id="cedula" name="cedula" placeholder="Ej. 12345678" required>
                    </div>

                    <div class="form-group">
                        <label for="mail">Correo Electrónico</label>
                        <input type="email" id="mail" name="mail" placeholder="ejemplo@correo.com" required>
                    </div>

                    <div class="form-group">
                        <label for="curso">Seleccione el Curso</label>
                        <select id="curso" name="codigocurso" required>
                            <option value="" disabled selected>Elija una especialidad...</option>
                            <option value="1">PHP - Backend Básico</option>
                            <option value="2">ASP - Inglés Avanzado</option>
                            <option value="3">Cursos Iny</option>
                            <option value="4">Web Sairs - Frontend</option>
                        </select>
                    </div>

                    <div class="btn-group">
                        <button type="submit" class="btn-guardar">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Alumno
                        </button>
                        <a href="alumnos.php" class="btn-cancelar">Cancelar</a>
                    </div>

                </form>
            </div>

        </div>
    </div>

</body>
</html>