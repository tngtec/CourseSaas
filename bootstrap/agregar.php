<html>
<html>

<head>
  <title>Problema</title>
</head>

<body>
  <?php
  $conexion = mysqli_connect("localhost", "root", "", "base1") or
    die("Problemas con la conexión");

  


$cedula = filter_var($_REQUEST['cedula'], FILTER_SANITIZE_NUMBER_INT);
$nombre = filter_var($_REQUEST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
$mail = filter_var($_REQUEST['mail'], FILTER_SANITIZE_EMAIL);
$codigocurso = filter_var($_REQUEST['codigocurso'], FILTER_SANITIZE_NUMBER_INT);




   if (empty($_REQUEST ['nombre']) and empty($_REQUEST ['cedula']) and empty($_REQUEST['mail'])) {
        die ("Error: Los Campos Nombre , cedula y Correo electronico son obligatorio.<br>");
    }


   if (empty($_REQUEST ['nombre']) and empty($_REQUEST ['mail'])) {
        die ("Error: Los Campos Nombre  y correo electronico son obligatorio.<br>");
    }


     if (empty($_REQUEST ['nombre']) and empty($_REQUEST ['cedula'])) {
        die ("Error: Los Campos Nombre  y cedula son obligatorio.<br>");
    }
     
   if (empty($_REQUEST ['cedula']) and empty($_REQUEST ['mail'])) {
        die ("Error: Los Campos cedula  y correo electronico son obligatorio.<br>");
     
    
      }

    if (empty($_REQUEST ['cedula'])) {
        die ("Error: El campo  cedula es obligatorio.<br>");
    }

    if (empty($_REQUEST ['nombre'])) {
        die ("Error: El campo nombre es obligatorio.<br>");
    
     }
   
 
     if (ctype_digit($_REQUEST['nombre'])) {
    die(" Error  el campo nombre contiene solo números");
}

if (!filter_var($_REQUEST['mail'], FILTER_VALIDATE_EMAIL)) {
 die(" Error  el campo  correo electronicos es  obligatorio");
}




// Preparar la consulta
$stmt = $conexion->prepare("INSERT INTO alumnos (cedula, nombre, mail, codigocurso) VALUES (?, ?, ?, ?)");

// Vincular los parámetros i entero s caracter s caracter s caracter
$stmt->bind_param("isss", $cedula, $nombre, $mail, $codigocurso);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "El alumno fue registrado con éxito";
} else {
    echo "Error en el registro: " . $stmt->error;
}

  // Cerrar la conexión
  $stmt->close();
 
  ?>
</body>

</html>