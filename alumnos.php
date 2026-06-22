<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la variable de sesión 'usuario' no existe, lo manda directo al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// CONSULTA CORREGIDA: Solo llamamos a la tabla alumnos para evitar el Fatal Error
$query = "SELECT cedula, nombre, mail, codigocurso FROM alumnos";
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
    
    <style>
        /* Ajustes específicos para el estado active del Sidebar */
        .menu-item.active { background: rgba(255, 255, 255, 0.05); border-left: 4px solid #3b82f6; }
        .menu-item.active a { color: #4ea8de; font-weight: 600; }

        /* Estilos profesionales para el nuevo filtro por curso */
        .filter-select {
            background-color: #f8fafc;
            color: #334155;
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
        }
        .filter-select:focus {
            border-color: #3b82f6;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
                    <div class="table-title">
                        <h2>Gestión de Alumnos</h2>
                    </div>
                    
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <select class="filter-select" id="filtroCurso" onchange="filtrarAlumnos()">
                            <option value="">🔍 Filtrar por Curso: Todos</option>
                            <option value="PHP">PHP</option>
                            <option value="ASP">ASP</option>
                            <option value="JSP">JSP</option>
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
                            <th style="text-align: center;">Acciones Disponibles</th>
                        </tr>
                    </thead>
                    <tbody id="tablaAlumnosBody">
                        
                        <?php
                        // Validamos si la base de datos contiene registros
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($reg = mysqli_fetch_array($resultado)) {
                                // Iniciales para el avatar
                                $iniciales = strtoupper(substr($reg['nombre'], 0, 2));
                                
                                // Tu lógica original de switch para pintar los nombres de los cursos
                                $nombreCurso = "";
                                switch ($reg['codigocurso']) {
                                    case 1:
                                        $nombreCurso = "PHP";
                                        break;
                                    case 2:
                                        $nombreCurso = "ASP";
                                        break;
                                    case 3:
                                        $nombreCurso = "JSP";
                                        break;
                                    default:
                                        $nombreCurso = "No asignado (" . $reg['codigocurso'] . ")";
                                        break;
                                }
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
                                    <td data-curso-name="<?php echo $nombreCurso; ?>"><?php echo htmlspecialchars($nombreCurso); ?></td>
                                    <td><span class="badge-status">Inscrito / Activo</span></td>
                                    <td>
                                        <div class="actions" style="justify-content: center;">
                                           <button class="btn-action btn-show" title="Mostrar" onclick="window.location.href='ver_alumno.php?cedula=<?php echo $reg['cedula']; ?>'">
                                            <i class="fa-regular fa-eye"></i> Mostrar
                                            </button>
                                            <button class="btn-action btn-edit" title="Modificar" onclick="abrirModal('modificar', '<?php echo $reg['cedula']; ?>', '<?php echo htmlspecialchars($reg['nombre']); ?>', '<?php echo htmlspecialchars($reg['mail']); ?>', '<?php echo htmlspecialchars($nombreCurso); ?>')">
                                                <i class="fa-solid fa-pen"></i> Modificar
                                            </button>
                                            <button class="btn-action btn-delete" title="Eliminar" onclick="confirmarEliminar('<?php echo $reg['cedula']; ?>')">
                                                <i class="fa-solid fa-trash"></i> Eliminar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" style="text-align: center; color: #64748b; padding: 40px;">
                                    <i class="fa-solid fa-folder-open" style="font-size: 28px; margin-bottom: 10px; display: block; color: #cbd5e1;"></i>
                                    No se encontraron alumnos registrados en la base de datos.
                                </td>
                            </tr>
                            <?php
                        }
                        mysqli_close($conexion);
                        ?>

                    </tbody>
                </table>

            </div>
        </main>
    </div>

    <script>
        // Buscador y Filtro Cruzado Avanzado en tiempo real
        function filtrarAlumnos() {
            // 1. Obtener los valores de búsqueda tanto del input como del select de cursos
            let textoBuscar = document.getElementById('inputBuscar').value.toLowerCase();
            let cursoSeleccionado = document.getElementById('filtroCurso').value;
            
            let filas = document.querySelectorAll('#tablaAlumnosBody tr');
            
            filas.forEach(fila => {
                // Verificar que sea una fila con datos reales
                if(fila.cells.length > 1) {
                    let textoFila = fila.innerText.toLowerCase();
                    
                    // Obtener el curso directamente de la celda usando la propiedad de la celda del curso (columna 4, índice 3)
                    let cursoFila = fila.cells[3].getAttribute('data-curso-name');

                    // 2. Condiciones lógicas de filtrado cruzado
                    let cumpleBusqueda = textoFila.includes(textoBuscar);
                    let cumpleCurso = (cursoSeleccionado === "" || cursoFila === cursoSeleccionado);

                    // Si cumple ambas condiciones, se muestra; si no, se oculta
                    if (cumpleBusqueda && cumpleCurso) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                }
            });
        }

        // Alerta javascript para confirmar eliminación
        function confirmarEliminar(cedula) {
            if (confirm('¿Seguro que desea eliminar permanentemente al alumno con Cédula: ' + cedula + '?')) {
                window.location.href = 'procesar_alumno.php?accion=eliminar&cedula=' + cedula;
            }
        }

        // Modales
        function abrirModal(accion, cedula='', nombre='', mail='', curso='') {
            alert('Ejecutando acción: ' + accion + '\nEstudiante: ' + nombre + '\nCédula: ' + cedula);
        }
    </script>
</body>
</html>