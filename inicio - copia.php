<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
$usuario = htmlspecialchars($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Cursos de Inglés</title>
    <link rel="stylesheet" href="panel.css">
</head>
<body>
    <aside class="sidebar">
        <h2>Inglés Pro</h2>
        <ul>
            <li><a href="#">🏠 Inicio</a></li>
            <li><a href="#">📚 Mis cursos</a></li>
            <li><a href="#">📈 Progreso</a></li>
            <li><a href="#">💬 Soporte</a></li>
            <li><a href="logout.php">🔓 Cerrar sesión</a></li>
        </ul>
    </aside>

    <main class="contenido">
        <header>
            <h1>¡Hola, <?php echo $usuario; ?>!</h1>
            <p>Bienvenido a tu panel de aprendizaje.</p>
        </header>

        <section class="tarjetas">
            <div class="tarjeta">
                <h3>Mis cursos</h3>
                <p>Accede a tus clases activas</p>
            </div>
            <div class="tarjeta">
                <h3>Mi progreso</h3>
                <p>Visualiza tu avance por nivel</p>
            </div>
            <div class="tarjeta">
                <h3>Soporte</h3>
                <p>Estamos aquí para ayudarte</p>
            </div>
        </section>
    </main>
</body>
</html>