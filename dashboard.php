<?php
session_start();
require_once('config/conexion.php'); // como está en la misma carpeta php/
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
<?php if(isset($_GET['ok']) && $_GET['ok']==1): ?>
<style>
.overlay-berlin{position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('img/berlin.jpg');background-size:cover;background-position:center;}
.box-berlin{background:#fff;width:90%;max-width:420px;padding:30px;border-radius:18px;text-align:center;border-top:6px solid #1e8c5a;box-shadow:0 15px 40px rgba(0,0,0,.6);}
</style>
<div class="overlay-berlin" id="okBerlin">
  <div class="box-berlin">
    <div style="font-size:60px">✅</div>
    <h2 style="color:#1e8c5a;">¡Aceptamos tu solicitud!</h2>
    <p>Tu cotización fue recibida.<br>Equipo <b>ANGABE</b> te contactará.</p>
    <button onclick="document.getElementById('okBerlin').remove(); history.replaceState({},'',location.pathname)" style="margin-top:15px;background:#1e8c5a;color:#fff;border:none;padding:12px;width:100%;border-radius:8px;font-weight:bold;cursor:pointer;">Entendido</button>
  </div>
</div>
<?php endif; ?>

<div class="navbar">
    <div><b>ANGABE - Dashboard</b> | Sistema lcc</div>
    <div><?php echo $_SESSION['usuario']; ?> | <a href="logout.php">Cerrar sesión</a></div>
</div>
<div class="container">
<div class="card">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> a ANGABE</h2>
    <p>Rol de usuario: <b><?php echo $_SESSION['rol']; ?></b></p>
    <hr><br>
    <h3>Opciones disponibles:</h3>
    
    <a href="gestion_usuarios.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Usuarios</a>
    <a href="#" onclick="abrirCotizacion(); return false;" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Cotizaciones</a>

    <?php if(isset($_SESSION['rol']) && $_SESSION['rol'] == 'admin'): ?>
    <a href="admin_cotizaciones.php" style="display:block;background:#0d6efd;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;font-weight:bold;text-align:center;">🔑 VER COTIZACIONES RECIBIDAS (ADMIN)</a>
    <?php endif; ?>

    <div id="modal-cotizacion" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4); z-index:9999; justify-content:center; align-items:center;">
      <div style="background:#fdf6f0; width:90%; max-width:550px; border-radius:12px; padding:20px 25px; position:relative;">
        <span onclick="cerrarCotizacion()" style="position:absolute; top:10px; right:15px; cursor:pointer; font-size:20px;">x</span>
        <h2 style="color:#2d4a3e;">COTIZACION</h2>
        <form action="guardar-cotizaciones/cotizaciones.php" method="POST" enctype="multipart/form-data">      
          <label style="font-weight:bold;">Observaciones:</label>
          <textarea name="observaciones" style="width:100%; height:90px; background:#c8e6d8; border-radius:4px; padding:8px;" required></textarea>
          <div style="margin:10px 0; display:flex; gap:15px;">
              <label for="file1" style="cursor:pointer; font-size:30px; border:1px dashed #1e8c5a; padding:5px 10px; border-radius:5px;">📄</label>
              <input type="file" id="file1" name="documentos[]" multiple style="display:none;" onchange="mostrarArchivos(this, 'lista1')">
              <label for="file2" style="cursor:pointer; font-size:30px; border:1px dashed #1e8c5a; padding:5px 10px; border-radius:5px;">📁</label>
              <input type="file" id="file2" name="documentos2[]" multiple style="display:none;" onchange="mostrarArchivos(this, 'lista2')">
          </div>
          <div id="lista1" style="font-size:12px; color:green;"></div>
          <div id="lista2" style="font-size:12px; color:green;"></div>
          <textarea name="detalles" placeholder="Detalles adicionales..." style="width:100%; height:80px; background:#c8e6d8; border-radius:4px; padding:8px; margin-top:15px;"></textarea>
          <div style="margin:15px 0; text-align:right;"><label><input type="checkbox" required> Acepto Términos</label></div>
          <button type="submit" style="width:100%; background:#1e8c5a; color:white; padding:12px; border:none; border-radius:5px; font-weight:bold;">Enviar Solicitud</button>
        </form>
      </div>
    </div>
    <script>
    function abrirCotizacion(){ document.getElementById('modal-cotizacion').style.display='flex'; }
    function cerrarCotizacion(){ document.getElementById('modal-cotizacion').style.display='none'; }
    function mostrarArchivos(i,id){ let l=document.getElementById(id); l.innerHTML=""; for(let f of i.files){ l.innerHTML+="✔ "+f.name+"<br>"; } }
    </script>

    <a href="gestion_clases.php"style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Clases</a>    
    <a href="gestion_intercambio.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Intercambio </a>
    <a href="gestion_reportes.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Gestión de Reportes</a>
    <a href="logout.php" style="display:block;background:#1e8c5a;color:white;padding:12px;margin:10px;border-radius:5px;text-decoration:none;">Cerrar sesión</a>
</div>
</div>
</body>
</html> 

                