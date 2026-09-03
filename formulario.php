 <!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro ANGABE</title>
  <link rel="stylesheet" href="./css/formulario.css">
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="./css/modal.css">
  <link rel="stylesheet" href="./css/header.css">
  <link rel="stylesheet" href="css/cotizacion.css">

</head>
<body class="box-body">
  <header class="header">
    <div class="container">
      <nav class="header-nav">
        <div>
          <a class="link-webstudio" href="">ANGABE </a>
          <p class="salto">Lcc Traducciones</p>
        </div>
        
        
        <ul class="header-menu ">
            <li class="open_submenu"> <a class="link-header" href="./index.php"> Inicio</a></li>
            <li> <a class="link-header" href="./portafolio.php"> Clases</a></li>
            <li> <a class="link-header" href=""> Intercambio</a></li>
            <li> <a class="link-header" class="open-modal-btns" onclick="openModal()"> Cotizacion</a></li>
            <button class="open-modal-btn">Iniciar Sesión</button>

        </ul>
      </nav>

      <ul class="logo">
        <li class="logo__img">
            <img src="./imagenes svg/logos/logo lcc.png" alt="">   
        </li>    
      </ul>
    </div>
  </header>
  <!-- Modal -->
  <div class="modal-overlay" id="modalOverlay">
      <div class="modal">
          <h1 class="modal-title">ANGABE</h1>
          <button class="close-btn" id="closeBtn">&times;</button>
          <label for="usuario">Usuario</label>
          <input type="text" id="usuario">

          <label for="contrasena">Contraseña</label>
          <input type="password" id="contrasena">

          <div class="checkbox">
          <input type="checkbox" id="olvido">
          <label for="olvido" style="margin: 0;">Olvide mi contraseña</label>
          </div>

          <button class="login-btn">INICIAR SESION</button>

          <div class="div-register"><a class="register" href="./formulario.php">Registrarse</a></div>
      </div>
  </div> 
  <div class="form-container">
    <div class="line"></div>
    <!-- <h1 class="logo">ANGABE</h1>
    <h2 class="subtitle">LCC TRADUCCIONES</h2> -->

    <p class="welcome">Bienvenido LCC traducciones. Regístrate y sé parte de nuestra familia ANGABE online.</p>

    <form class="register-form" action="php/procesar_registro.php" method="POST"> 
      <label>E-mail *</label>
      <input type="email" name="correo" required>

      <label>Contraseña *</label>
      <input type="password" name="contrasena" required>

      <label>Confirmar contraseña *</label>
      <input type="password" name="confirmar_contrasena" required>

      <label>Nombre *</label>
      <input type="text" name="nombre" required>

      <label>Apellidos *</label>
      <input type="text" name="apellidos" required>

      <label>Documento *</label>
      <div class="documento">
        <input type="text" name="documento" required>
        <select name="tipo_documento">
          <option value="cc">CC</option>
          <option value="ti">TI</option>
          <option value="ce">CE</option>
        </select>
      </div>

      <label>Fecha nacimiento *</label>
      <div class="fecha">
        <input type="text" placeholder="DIA" required>
        <input type="text" placeholder="MES" required>
        <select required>
          <option value="">SELECCIÓN</option>
          <option value="2000">2000</option>
          <option value="2001">2001</option>
          <!-- Agrega más años -->
        </select>
      </div>

      <label>Sexo *</label>
      <select name="sexo"required>
        <option value="">SELECCIÓN</option>
        <option value="masculino">Masculino</option>
        <option value="femenino">Femenino</option>
        <option value="otro">Otro</option>
      </select>
    <br>
    <div class="checkbox-group">
      <label><input type="checkbox"> Deseo recibir ofertas por e-mail</label>
      <br>
      <label><input type="checkbox" required> Acepto <a href="#">política y tratamiento de mis datos</a> *</label>
      <br>
      <button type="submit">ENVIAR</button>
    </div>
  </div>
</form>

  <div id="mensajeExito" class="mensaje-exito oculto">¡Registro exitoso!</div>

  <script src="validacion.js"></script>
  <script src="./js/modal.js"></script>
</body>
</html>
