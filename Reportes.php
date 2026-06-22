<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Opcional: Proteger la vista si no hay sesión activa
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
    <title>CourseSaas - Reportes y Estadísticas</title>
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

        .topbar h1 {
            font-size: 26px;
            font-weight: 600;
            color: #1a202c;
            margin: 0;
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

        /* Grid de Reportes */
        .reports-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 10px;
        }

        @media (max-width: 992px) {
            .reports-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Tarjetas de Reportes */
        .report-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .report-card h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin: 0 0 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Gráfico Estadístico Visual (Simulado con CSS) */
        .chart-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            height: 200px;
            padding: 10px 20px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #edf2f7;
        }

        .chart-bar-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            gap: 8px;
        }

        .chart-bar {
            width: 35px;
            background: linear-gradient(180deg, #3b82f6 0%, #1d4ed8 100%);
            border-radius: 6px 6px 0 0;
            transition: height 0.5s ease;
        }

        .chart-bar-wrapper:nth-child(even) .chart-bar {
            background: linear-gradient(180deg, #10b981 0%, #047857 100%);
        }

        .chart-label {
            font-size: 12px;
            color: #718096;
            font-weight: 500;
        }

        /* Lista de Rendimiento / Top Cursos */
        .top-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .top-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #edf2f7;
        }

        .top-list-item:last-child {
            border-bottom: none;
        }

        .course-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .course-rank {
            width: 24px;
            height: 24px;
            background-color: #ebf8ff;
            color: #2b6cb0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }

        .course-name {
            font-weight: 500;
            color: #2d3748;
            font-size: 14px;
        }

        .course-meta {
            font-size: 14px;
            font-weight: 600;
            color: #4a5568;
        }

        /* Botón de Exportar */
        .btn-export {
            background-color: #ffffff;
            color: #4a5568;
            border: 1px solid #e2e8f0;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-export:hover {
            background-color: #f7fafc;
            border-color: #cbd5e0;
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
                <li class="menu-item"><a href="cursos.php"><i class="fa-solid fa-book"></i> Cursos</a></li>
                <li class="menu-item active"><a href="reportes.php"><i class="fa-solid fa-chart-pie"></i> Reportes</a></li>
            </ul>
        </div>
        <div class="logout">
            <a href="cerrar_sesion.php"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
    </aside>

    <div class="main-container">
        
        <header class="topbar">
            <h1>Reportes Estadísticos</h1>
            <div class="user-profile">
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                <span><?php echo $_SESSION['usuario'] ?? 'josegregorioraveloinfante@gmail.com'; ?> <i class="fa-solid fa-chevron-down" style="font-size: 11px; margin-left: 6px; color: #777;"></i></span>
            </div>
        </header>

        <main class="content-wrapper">
            
            <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
                <button class="btn-export"><i class="fa-solid fa-file-arrow-down"></i> Exportar Informe (PDF)</button>
            </div>

            <div class="reports-grid">
                
                <div class="report-card">
                    <h2><i class="fa-solid fa-chart-simple" style="color: #3b82f6;"></i> Nuevos Inscritos (Últimos 6 meses)</h2>
                    
                    <div class="chart-container">
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 40px;"></div>
                            <span class="chart-label">Ene</span>
                        </div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 75px;"></div>
                            <span class="chart-label">Feb</span>
                        </div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 110px;"></div>
                            <span class="chart-label">Mar</span>
                        </div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 90px;"></div>
                            <span class="chart-label">Abr</span>
                        </div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 150px;"></div>
                            <span class="chart-label">May</span>
                        </div>
                        <div class="chart-bar-wrapper">
                            <div class="chart-bar" style="height: 135px;"></div>
                            <span class="chart-label">Jun</span>
                        </div>
                    </div>
                </div>

                <div class="report-card">
                    <h2><i class="fa-solid fa-fire" style="color: #e63946;"></i> Cursos Populares</h2>
                    
                    <ul class="top-list">
                        <li class="top-list-item">
                            <div class="course-info">
                                <span class="course-rank">1</span>
                                <span class="course-name">Inglés Avanzado</span>
                            </div>
                            <span class="course-meta">45 Alum.</span>
                        </div>
                        <li class="top-list-item">
                            <div class="course-info">
                                <span class="course-rank">2</span>
                                <span class="course-name">Cursos Iny</span>
                            </div>
                            <span class="course-meta">32 Alum.</span>
                        </div>
                        <li class="top-list-item">
                            <div class="course-info">
                                <span class="course-rank">3</span>
                                <span class="course-name">Web Sairs</span>
                            </div>
                            <span class="course-meta">28 Alum.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </main>
    </div>

</body>
</html>