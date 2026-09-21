<?php session_start(); 
$isLogged = isset($_SESSION['id_usuario']) || isset($_SESSION['usuario']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LCC-ANGABE</title>
    <link rel="stylesheet" href="moderno-normalizar.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/cotizacion.css">
    <link rel="stylesheet" href="./css/card-info.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/banner.css">
    <link rel="stylesheet" href="./css/team.css">
</head>
<body class="box-body">
<header class="header">
    <div class="container">
        <nav class="header-nav">
            <div>
                 <a class="link-webstudio" href="">ANGABE </a>
                 <p class="salto">Lcc Traducciones</p>
            </div>
            <ul class="header-menu">
              <li><a class="link-header barra" href="./index.php"> Inicio</a></li>
              <li><a class="link-header" href="#" onclick="servicioNoDisponible(); return false;"> Clases</a></li>
              <li><a class="link-header" href="#" onclick="servicioNoDisponible(); return false;"> Intercambio</a></li>
              <li><a class="link-header" href="#" onclick="openCotizacion(); return false;"> Cotizacion</a></li>
            </ul>
            <button class="open-modal-btn" onclick="openLogin()" type="button">Iniciar Sesión</button>
        </nav>
    </div>
</header>

<main>
    <section class="banner">
        <h1 class="title-pal">SOLUCIONES EFICACES</h1>
        <div class="buttons banner-button">
            <button class="open-modal-btns" onclick="openCotizacion()" type="button">COTIZA AHORA</button>
        </div>
        <div class="banner-overlay"></div>
    </section>

    <!-- MODAL LOGIN -->
    <div class="modal-overlay" id="modalOverlay" style="display: none;">
        <div class="modal">
            <form action="login.php" method="POST">
                <h1 class="modal-title">ANGABE</h1>
                <button class="close-btn" id="closeBtn" type="button">&times;</button>
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" required>
                <label for="contrasena">Contraseña</label>
                <input type="password" id="contrasena" name="contrasena" required>
                <div class="checkbox">
                    <input type="checkbox" id="olvido">
                    <label for="olvido">Olvide mi contraseña</label>
                </div>
                <button class="login-btn" type="submit">INICIAR SESION</button>
                <div class="div-register"><a class="register" href="./formulario.php">Registrarse</a></div>
            </form>
        </div>
    </div>

    <!-- MODAL COTIZACION -->
    <div class="modal-overlay" id="modalFormulario" style="display: none;">
        <div class="modal-content">
            <span class="close-btn" id="closecotizacionBtn">&times;</span>
            <h2>COTIZACION</h2>
            <label for="observaciones">Observaciones:</label>
            <textarea id="observaciones" placeholder="Escribe tus observaciones aquí..."></textarea>
            <label>Adjuntar documentos:</label>
            <div class="file-section">
                <label><input type="file" id="file1" hidden><img src="https://img.icons8.com/ios-filled/50/000000/document.png" onclick="document.getElementById('file1').click();"></label>
                <label><input type="file" id="file2" hidden><img src="https://img.icons8.com/ios-filled/50/000000/folder-invoices--v1.png" onclick="document.getElementById('file2').click();"></label>
            </div>
            <textarea placeholder="Detalles adicionales..."></textarea>
            <div class="checkbox-section">
                <input type="checkbox" id="terminos"><label for="terminos">Acepto Términos y condiciones</label>
            </div>
            <button class="submit-btn" type="button" onclick="enviarFormulario()">Enviar Solicitud De Cotización</button>
        </div>
    </div>

    <section class="main-portafolio">
        <h2 class="title-galery">A qué nos dedicamos</h2>
        <section class="list-card">
            <div class="list-boxcard">
                <section class="list-product">
                    <div class="card-animation">
                        <img src="imagenes/clasesaleman.jpg" alt="">
                        <div class="card-emergent"><p>Contamos con cursos en el idioma Aleman, para q aprendas o te refurces en este idioma.</p></div>
                    </div>
                    <div class="card-body"><h3 class="title-img-portafolio">Clases De Alemán</h3></div>
                </section>
                <section class="list-product">
                    <div class="card-animation">
                        <img src="imagenes/traducc.png" alt="">
                        <div class="card-emergent"><p>Lcc traducciones tiene asocio con traductores de aleman, ingles, italiano, frances y portugues.</p></div>
                    </div>
                    <div class="card-body"><h3 class="title-img-portafolio">Traducciones</h3></div>
                </section>
                <section class="list-product">
                    <div class="card-animation">
                        <img src="imagenes/intercambio.jpg" alt="">
                        <div class="card-emergent"><p>Tenemos asesoria para intercambios universitarios y asesoria de Aupair. En Alemania, Austria, Suiza, Luxemburgo y Liechtenstein.</p></div>
                    </div>
                    <div class="card-body"><h3 class="title-img-portafolio">Intercambio Cultural</h3></div>
                </section>
            </div>
        </section>
    </section>
</main>

<footer class="footer">
    <div>
        <a class="link-webstudio-footer" href=""> ANGABE</a>
        <address>
            <ul class="pie-pag-email-tel">
                <li><a class="piepag-direcion" href="">Bogota, Colombia</a></li>
                <li><a class="header-email" href="">info@Angabe.com</a></li>
                <li><a class="header-tel" href="">+52 55 5529 6000 </a></li>
            </ul>
        </address>
    </div>
</footer>

<script>
// Variable que viene de PHP para saber si esta logueado
var usuarioLogueado = <?php echo $isLogged ? 'true' : 'false'; ?>;

function openLogin(){
  document.getElementById('modalOverlay').style.display='flex';
  document.getElementById('modalFormulario').style.display='none';
}

function openCotizacion(){
  if(usuarioLogueado){
    // Si esta logueado, si deja cotizar
    document.getElementById('modalOverlay').style.display='none';
    document.getElementById('modalFormulario').style.display='flex';
  } else {
    // Si NO esta logueado, lo mandamos a registrarse
    window.location.href = "./formulario.php";
  }
}

function servicioNoDisponible(){
  alert("Este servicio no esta disponible por el momento. Estara disponible en una proxima actualizacion.");
}

function closeAll(){
  document.getElementById('modalOverlay').style.display='none';
  document.getElementById('modalFormulario').style.display='none';
}
document.getElementById('closeBtn').onclick = closeAll;
document.getElementById('closecotizacionBtn').onclick = closeAll;
window.onclick = function(e){
  if(e.target.id === 'modalOverlay' || e.target.id === 'modalFormulario'){ closeAll(); }
}
function enviarFormulario(){ alert('Cotización enviada'); closeAll(); }
</script>
</body>
</html>