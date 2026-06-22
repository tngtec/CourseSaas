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
    <title>CourseSaas - Panel de Control</title>
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

        /* Grid de Tarjetas del Dashboard */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 10px;
        }

        .card-stat {
            background: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-stat-info h3 {
            color: #666666;
            font-size: 16px;
            font-weight: 500;
            margin: 0 0 12px 0;
        }

        .card-stat-info p {
            font-size: 46px;
            font-weight: 700;
            margin: 0;
        }

        .card-stat-icon {
            font-size: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Colores temáticos */
        .card-alumnos p { color: #1e3a8a; }
        .card-alumnos i { color: #10b981; }

        .card-cursos p { color: #10b981; }
        .card-cursos i { color: #2ec4b6; }

        .card-cupos p { color: #dc2626; }
        .card-cupos i { color: #e63946; }

        .progress-bar-container {
            width: 100%;
            background-color: #f3f4f6;
            border-radius: 6px;
            height: 6px;
            margin-top: 18px;
        }

        .progress-bar {
            background-color: #dc2626;
            height: 100%;
            border-radius: 6px;
            width: 65%;
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
                <li class="menu-item active"><a href="inicio.php"><i class="fa-solid fa-house"></i> Home</a></li>
                <li class="menu-item"><a href="alumnos.php"><i class="fa-solid fa-users"></i> Alumnos</a></li>
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
            <h1>System CourseSaas</h1>
            <div class="user-profile">
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="Avatar">
                <span><?php echo $_SESSION['usuario'] ?? 'josegregorioraveloinfante@gmail.com'; ?> <i class="fa-solid fa-chevron-down" style="font-size: 11px; margin-left: 6px; color: #777;"></i></span>
            </div>
        </header>

        <main class="content-wrapper">
            
            <div class="dashboard-cards">
                
                <div class="card-stat card-alumnos">
                    <div class="card-stat-info">
                        <h3>Total de Alumnos</h3>
                        <p>125</p>
                    </div>
                    <div class="card-stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                </div>

                <div class="card-stat card-cursos">
                    <div class="card-stat-info">
                        <h3>Cursos Activos</h3>
                        <p>12</p>
                    </div>
                    <div class="card-stat-icon">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                </div>

                <div class="card-stat card-cupos" style="flex-direction: column; align-items: stretch; justify-content: center;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <div class="card-stat-info">
                            <h3>Cupos Disponibles</h3>
                            <p>15</p>
                        </div>
                        <div class="card-stat-icon">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                    </div>
                    <div class="progress-bar-container">
                        <div class="progress-bar"></div>
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>
</html>