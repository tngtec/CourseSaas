<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Opcional: Descomenta estas líneas si quieres proteger la vista
// if (!isset($_SESSION['usuario'])) {
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Gestión de Cursos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
    
    <style>
        body {
            display: flex;
            margin: 0;
            background-color: #f0f2f5;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .main-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: transparent;
        }

        .search-container {
            position: relative;
            width: 350px;
        }

        .search-container input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            background-color: #ffffff;
            font-size: 14px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
            outline: none;
            transition: all 0.2s;
        }

        .search-container input:focus {
            border-color: #3b82f6;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }

        .search-container i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 16px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-profile img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
        }

        .content-wrapper {
            padding: 0 40px 40px 40px;
        }

        /* Contenedor de la Tabla / Sección Blanca */
        .crud-container {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .crud-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .crud-header h2 {
            font-size: 22px;
            font-weight: 600;
            color: #1a202c;
            margin: 0;
        }

        .btn-add {
            background-color: #2563eb;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.2s;
        }

        .btn-add:hover {
            background-color: #1d4ed8;
        }

        /* Tabla Estilizada */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .data-table th {
            color: #a0aec0;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            padding: 16px 20px;
            border-bottom: 1px solid #edf2f7;
        }

        .data-table td {
            padding: 20px;
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
            font-size: 15px;
        }

        .course-title {
            font-weight: 600;
            color: #1a202c;
        }

        /* Badges de Estado */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-active {
            background-color: #e6fffa;
            color: #319795;
        }

        .badge-paused {
            background-color: #feebc8;
            color: #dd6b20;
        }

        /* Botones de Acción */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 8px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e2e8f0;
            color: #4a5568;
            background: #ffffff;
            transition: all 0.2s;
        }

        .btn-action:hover {
            background-color: #f7fafc;
            border-color: #cbd5e0;
        }

        .btn-delete:hover {
            background-color: #fff5f5;
            border-color: #fed7d7;
            color: #e53e3e;
        }
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
                <li class="menu-item"><a href="alumnos.php"><i class="fa-solid fa-users"></i> Alumnos</a></li>
                <li class="menu-item active"><a href="cursos.php"><i class="fa-solid fa-book"></i> Cursos</a></li>
                <li class="menu-item"><a href="reportes.php"><i class="fa-solid fa-chart-pie"></i> Reportes</a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
    </aside>

    <div class="main-container">
        
        <header class="topbar">
            <div class="search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Buscar curso por código o nombre...">
            </div>
            
            <div class="user-profile">
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                <span><?php echo $_SESSION['usuario'] ?? 'josegregorioraveloinfante@gmail.com'; ?> <i class="fa-solid fa-chevron-down" style="font-size: 11px; margin-left: 6px; color: #777;"></i></span>
            </div>
        </header>

        <main class="content-wrapper">
            
            <div class="crud-container">
                <div class="crud-header">
                    <h2>Gestión de Cursos</h2>
                    <a href="registrar_curso.php" class="btn-add">
                        <i class="fa-solid fa-plus"></i> Registrar Curso
                    </a>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Curso / Especialidad</th>
                            <th>Alumnos Inscritos</th>
                            <th>Estado</th>
                            <th>Acciones Disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>ASP</strong></td>
                            <td class="course-title">Cursos Inglés Avanzado</td>
                            <td>45 Estudiantes</td>
                            <td><span class="badge badge-active">Activo</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action"><i class="fa-solid fa-eye"></i> Mostrar</a>
                                    <a href="#" class="btn-action"><i class="fa-solid fa-pen"></i> Modificar</a>
                                    <a href="#" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i> Eliminar</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>INY</strong></td>
                            <td class="course-title">Cursos Iny</td>
                            <td>32 Estudiantes</td>
                            <td><span class="badge badge-active">Activo</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action"><i class="fa-solid fa-eye"></i> Mostrar</a>
                                    <a href="#" class="btn-action"><i class="fa-solid fa-pen"></i> Modificar</a>
                                    <a href="#" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i> Eliminar</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>WBS</strong></td>
                            <td class="course-title">Web Sairs - Frontend</td>
                            <td>28 Estudiantes</td>
                            <td><span class="badge badge-paused">En Pausa</span></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="#" class="btn-action"><i class="fa-solid fa-eye"></i> Mostrar</a>
                                    <a href="#" class="btn-action"><i class="fa-solid fa-pen"></i> Modificar</a>
                                    <a href="#" class="btn-action btn-delete"><i class="fa-solid fa-trash"></i> Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>