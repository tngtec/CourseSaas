
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="styleregistro.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<!-- formulario de inicio sesion del Sistema de Apoyo Estudiantil donde ingresa Usuario y Contraseña  -->
 </head>
 <body>
  <div class="container">
    <div class="login-container text-center">
      <img src="img/uneg.jpeg" alt="Logo" class="logo">
      <h4 class="mb-4">COURSE SAAS  SYSTEM</h4>
      
      <form id="myForm" action="controlador_login.php" method="POST" autocomplete="off">
      
        <div class="form-group mb-3 text-start position-relative ">
          <label for="usuario"><strong>Usuario</strong></label>
          <input type="email" class="form-control" id="usuario" name="usuario" placeholder="ejemplo@correo.com" autocomplete="new-username">
          <div class="invalid-feedback">Ingresa un correo electrónico válido.</div>
        </div> 
      

        <div class="form-group mb-3 text-start position-relative">
          <label for="contrasena"><strong>Contraseña</strong></label>
          <input type="password" class="form-control" id="contrasena" name="contrasena" autocomplete="new-password">
          <i class="fa fa-eye position-absolute" id="toggleIcon" onclick="togglePassword()" style="top: 38px; right: 15px; cursor: pointer; display: none;"></i>
          <div class="invalid-feedback">Ingresa una contraseña de al menos 6 caracteres.</div>
          <div class="mt-1">
            <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
          </div>
        </div>
     
       <!--<button type="submit" class="btn btn-primary w-100" aria-label="Iniciar sesión">Iniciar Sesión</button>  -->
       <input type="submit"class="btn btn-primary w-100" name="btningresar" value="Iniciar Sesión">
      </form>

      <p class="mt-3">
        ¿No tienes cuenta? <a href="registro.html">Regístrate</a>
      </p>
    </div>
  </div>

  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="validadorLogin.js"></script>
 
     
</body>
</html>