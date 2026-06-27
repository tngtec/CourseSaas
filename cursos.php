<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$conexion = mysqli_connect("localhost", "root", "", "base1") or die("Problemas con la conexión");

// Consulta que une cursos con alumnos y cuenta los inscritos
$query = "SELECT c.codigo, c.nombre_curso, c.profesor, c.estado, 
          COUNT(a.cedula) as total_alumnos 
          FROM cursos c 
          LEFT JOIN alumnos a ON c.codigo = a.codigocurso 
          GROUP BY c.codigo";

$resultado = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CourseSaas - Gestión de Cursos</title>
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
            <div class="search-wrapper">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" class="search-input" id="inputBuscarCurso" placeholder="Buscar curso o profesor..." onkeyup="filtrarCursos()">
            </div>
            <div class="user-profile">
                <div class="user-avatar"><i class="fa-regular fa-user"></i></div>
                <span><?php echo $_SESSION['usuario'] ?? 'Administrador'; ?></span>
            </div>
        </header>

        <main class="content">
            <div class="card-table">
                
                <div class="table-header">
                    <h2>Gestión de Cursos</h2>
                    <div style="display: flex; gap: 10px; align-items: center;">
                        <button class="btn-register" onclick="window.location.href='registrar_curso.php'">
                            <i class="fa-solid fa-plus"></i> Nuevo Curso
                        </button>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Profesor</th>
                            <th>Estado</th>
                            <th>Alumnos Inscritos</th>
                            <th style="text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tablaCursosBody">
                        <?php
                        if (mysqli_num_rows($resultado) > 0) {
                            while ($reg = mysqli_fetch_array($resultado)) { 
                                // Determinar si está activo para ponerle color verde o gris
                                $estadoClase = ($reg['estado'] == 'Activo') ? 'badge-status' : 'badge-status inactive';
                        ?>
                        <tr>
                            <td>
                                <div class="student-cell">
                                    <div class="avatar-circle" style="background-color: #f1f5f9; color: #475569;">
                                        <i class="fa-solid fa-book-open" style="font-size: 14px;"></i>
                                    </div>
                                    <strong><?php echo htmlspecialchars($reg['nombre_curso']); ?></strong>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars($reg['profesor']); ?></td>
                            <td><span class="<?php echo $estadoClase; ?>"><?php echo htmlspecialchars($reg['estado']); ?></span></td>
                            <td>
                                <span style="font-weight:600; color:#3b82f6; background: #eff6ff; padding: 4px 10px; border-radius: 6px;">
                                    <?php echo $reg['total_alumnos']; ?> <i class="fa-solid fa-user-group" style="font-size:12px; margin-left:4px;"></i>
                                </span>
                            </td>
                            <td>
                                <div class="actions" style="justify-content: center;">
                                    <button class="btn-action btn-edit" title="Modificar" onclick="window.location.href='modificar_curso.php?codigo=<?php echo $reg['codigo']; ?>'">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                    <button class="btn-action btn-delete" title="Eliminar" onclick="confirmarEliminarCurso('<?php echo $reg['codigo']; ?>')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='5' style='text-align:center; padding:40px;'>No hay cursos registrados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function filtrarCursos() {
            let textoBuscar = document.getElementById('inputBuscarCurso').value.toLowerCase();
            let filas = document.querySelectorAll('#tablaCursosBody tr');
            
            filas.forEach(fila => {
                if(fila.cells.length > 1) {
                    let textoFila = fila.innerText.toLowerCase();
                    if (textoFila.includes(textoBuscar)) {
                        fila.style.display = '';
                    } else {
                        fila.style.display = 'none';
                    }
                }
            });
        }

        function confirmarEliminarCurso(codigo) {
            if (confirm('¿Seguro que desea eliminar el curso con código: ' + codigo + '?')) {
                // Aquí deberías redirigir a tu archivo que elimina cursos
                window.location.href = 'procesar_curso.php?accion=eliminar&codigo=' + codigo;
            }
        }
    </script>
</body>
</html>
<?php mysqli_close($conexion); ?>