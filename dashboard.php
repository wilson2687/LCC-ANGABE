<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard ANGABE - inicio</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                background-image: url('imagenes/img-berlin.png');
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
            }
        .navbar {background-color:#1e8c5a; color: white; padding: 15px 30px; display:flex; justify-content:space-between; align-items:center;}
        .navbar a {color: #purple; text-decoration:none; font-weight:bold;}
        .container {padding:30px;}
        .card {background:rgba(255,255,255,0.92);padding:25px;border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.5);}
    </style>

        </head>
        <body>
            <div class="navbar">
                <div><b>ANGABE - Dashboard</b> | Sistema lcc</div>
                <div>
                    <?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a>
                </div>
            </div>
            <div class="container">
                <div class="card">

                <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> a ANGABE</h2>
                <p>Este es tu panel de control.</p>
                <p>panel de control para la gestión de usuarios y otras funcionalidades del sistema.</p>
                <p>Rol de usuario: <?php echo $_SESSION['rol']; ?></p>
<hr><br>
<h3>Opciones disponibles:</h3>
<a href="gestion_usuarios.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Usuarios</a>


<!-- BOTON -->
<a href="#" onclick="abrirCotizacion(); return false;" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none; text-align:flex-start;">Gestión de Cotizaciones</a>

<!-- MODAL COTIZACION -->
<div id="modal-cotizacion" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; justify-content:center; align-items:center;">
  <div style="background:#fdf6f0; width:90%; max-width:550px; border-radius:12px; padding:20px 25px; box-shadow:0 10px 30px rgba(0,0,0,0.3); position:relative; font-family:Arial, sans-serif;">
    
    <span onclick="cerrarCotizacion()" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px; color:#888;">x</span>
    
    <h2 style="margin:0 0 15px 0; color:#2d4a3e; font-family:serif; letter-spacing:1px;">COTIZACION</h2>

    <form action="guardar_cotizacion.php" method="POST" enctype="multipart/form-data">
      
      <label style="font-weight:bold; font-size:14px;">Observaciones:</label>
      <textarea name="observaciones" placeholder="Escribe tus observaciones aquí..." style="width:100%; height:90px; background:#c8e6d8; border:1px solid #b0c4b9; border-radius:4px; padding:8px; margin-top:5px; box-sizing:border-box; resize:vertical;" required></textarea>

      <label style="font-weight:bold; font-size:14px; margin-top:15px; display:block;">Adjuntar documentos:</label>
      <div style="margin:10px 0; display:flex; gap:15px;">
          <label style="cursor:pointer; font-size:30px;">📄<input type="file" name="documentos[]" hidden multiple></label>
          <label style="cursor:pointer; font-size:30px;">📁<input type="file" name="documentos2[]" hidden multiple></label>
      </div>
      <p style="font-size:11px; color:#888; margin-top:-5px;">Puedes adjuntar PDF, JPG, PNG</p>

      <textarea name="detalles" placeholder="Detalles adicionales..." style="width:100%; height:80px; background:#c8e6d8; border:1px solid #b0c4b9; border-radius:4px; padding:8px; margin-top:10px; box-sizing:border-box; resize:vertical;"></textarea>

      <div style="margin:15px 0 10px 0; text-align:right;">
        <label style="font-size:13px;"><input type="checkbox" required> Acepto Términos y condiciones</label>
      </div>

      <button type="submit" style="width:100%; background:#1e8c5a; color:white; border:none; padding:10px; border-radius:4px; font-weight:bold; cursor:pointer;">Enviar Solicitud De Cotización</button>

    </form>
  </div>
</div>

<script>
function abrirCotizacion(){
  document.getElementById('modal-cotizacion').style.display='flex';
}
function cerrarCotizacion(){
  document.getElementById('modal-cotizacion').style.display='none';
}
</script>
<a href="gestion_clases.php"style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Clases</a>    
<a href="gestion_intercambio.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Intercambio </a>
<a href="gestion_reportes.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Reportes</a>
<a href="logout.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Cerrar sesión</a>
                </div>

            </div>
            </div>
        </body>
</html> 

                