<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// CONSULTA OPTIMIZADA: Usamos LEFT JOIN para obtener el nombre del curso automáticamente
$query = "SELECT a.cedula, a.nombre, a.mail, a.codigocurso, c.nombre_curso 
          FROM alumnos a 
          LEFT JOIN cursos c ON a.codigocurso = c.codigo";
$resultado = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Gestión de Alumnos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="estilo.css">
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
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="search-input" id="inputBuscar" placeholder="Buscar estudiante por Cédula, Nombre o Correo..." onkeyup="filtrarAlumnos()">
            </div>
            <div class="user-profile">
                <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                <span><?php echo $_SESSION['usuario'] ?? 'Administrador'; ?></span>
            </div>
        </header>

        <main class="content">
            <div class="card-table">
                <div class="table-header">
                    <h2>Gestión de Alumnos</h2>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <select class="filter-select" id="filtroCurso" onchange="filtrarAlumnos()">
                            <option value="">🔍 Filtrar por Curso: Todos</option>
                            <?php
                            // Opcional: Cargar cursos dinámicamente en el filtro
                            $resCursos = mysqli_query($conexion, "SELECT nombre_curso FROM cursos");
                            while($c = mysqli_fetch_array($resCursos)) {
                                echo "<option value='{$c['nombre_curso']}'>{$c['nombre_curso']}</option>";
                            }
                            ?>
                        </select>
                        <button class="btn-register" onclick="window.location.href='registrar_alumno.php'">
                            <i class="fa-solid fa-user-plus"></i> Registrar Alumno
                        </button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Estudiante</th>
                            <th>Cédula</th>
                            <th>Mail</th>
                            <th>Curso</th>
                            <th>Estado</th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaAlumnosBody">
                        <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($reg = mysqli_fetch_array($resultado)) {
                                $iniciales = strtoupper(substr($reg['nombre'], 0, 2));
                                $nombreCurso = $reg['nombre_curso'] ? $reg['nombre_curso'] : "Sin asignar";
                                ?>
                                <tr>
                                    <td>
                                        <div class="student-cell">
                                            <div class="avatar-circle"><?php echo $iniciales; ?></div>
                                            <strong><?php echo htmlspecialchars($reg['nombre']); ?></strong>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($reg['cedula']); ?></td>
                                    <td><?php echo htmlspecialchars($reg['mail']); ?></td>
                                    <td data-curso-name="<?php echo htmlspecialchars($nombreCurso); ?>">
                                        <?php echo htmlspecialchars($nombreCurso); ?>
                                    </td>
                                    <td><span class="badge-status">Inscrito / Activo</span></td>
                                    <td>
                                        <div class="actions" style="justify-content: center;">
                                            <button class="btn-action btn-show" onclick="window.location.href='ver_alumno.php?cedula=<?php echo $reg['cedula']; ?>'"><i class="fa-regular fa-eye"></i></button>
                                            <button class="btn-action btn-edit" onclick="window.location.href='modificar_alumno.php?cedula=<?php echo $reg['cedula']; ?>'"><i class="fa-solid fa-pen"></i></button>
                                            <button class="btn-action btn-delete" onclick="confirmarEliminar('<?php echo $reg['cedula']; ?>')"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center; padding:40px;'>No hay alumnos registrados.</td></tr>";
                        }
                        mysqli_close($conexion);
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function filtrarAlumnos() {
            let textoBuscar = document.getElementById('inputBuscar').value.toLowerCase();
            let cursoSeleccionado = document.getElementById('filtroCurso').value;
            let filas = document.querySelectorAll('#tablaAlumnosBody tr');
            
            filas.forEach(fila => {
                if(fila.cells.length > 1) {
                    let textoFila = fila.innerText.toLowerCase();
                    let cursoFila = fila.cells[3].getAttribute('data-curso-name');
                    let cumpleBusqueda = textoFila.includes(textoBuscar);
                    let cumpleCurso = (cursoSeleccionado === "" || cursoFila === cursoSeleccionado);
                    fila.style.display = (cumpleBusqueda && cumpleCurso) ? '' : 'none';
                }
            });
        }

        function confirmarEliminar(cedula) {
            if (confirm('¿Seguro que desea eliminar al alumno con Cédula: ' + cedula + '?')) {
                window.location.href = 'procesar_alumno.php?accion=eliminar&cedula=' + cedula;
            }
        }
    </script>
</body>
</html>