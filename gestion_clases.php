<?php
include 'config/conexion.php';
session_start();
$rol = strtolower($_SESSION['ROL'] ?? $_SESSION['rol'] ?? 'cliente');
?>
<!DOCTYPE html>
<html>
<head>
<title>Clases</title>
<style>
body{
  margin:0;
  min-height:100vh;
  background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('imagenes/img-berlin.png');
  background-size:cover;
  background-position:center;
  background-attachment:fixed;
  font-family:'Segoe UI', sans-serif;
  color:white;
}
.center{
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  text-align:center;
  padding:20px;
}
.card-blanco{
  background:white;
  color:#0f172a;
  padding:40px 50px;
  border-radius:20px;
  box-shadow:0 20px 40px rgba(0,0,0,0.3);
}
.grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:20px; max-width:1100px; margin:auto; padding:20px;}
.card{background:rgba(255,255,255,0.96); color:#0f172a; border-radius:18px; padding:25px; box-shadow:0 10px 30px rgba(0,0,0,0.3);}
.badge{display:inline-block; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:bold;}
.a1{background:#dcfce7; color:#166534;} .a2{background:#dbeafe; color:#1e40af;} .b1{background:#fef9c3; color:#854d0e;}
.btn{display:inline-block; margin-top:15px; padding:10px 20px; border-radius:20px; text-decoration:none; font-weight:bold;}
</style>
</head>
<body>

<?php if($rol != 'admin'){ ?>
<!-- VISTA CLIENTE - NO DISPONIBLE -->
<div class="center">
  <div class="card-blanco">
    <h2>🎓 Clases e Intercambio</h2>
    <div style="background:#fff3cd;padding:20px;border-radius:12px;border:1px solid #ffe69c; max-width:500px">
      Este servicio no está disponible por el momento.<br>Estamos trabajando para traerlo de vuelta pronto.
    </div><br><br>
    <a href="dashboard.php" style="background:#555;color:white;padding:10px 20px;border-radius:20px;text-decoration:none">Volver</a>
  </div>
</div>

<?php } else { ?>
<!-- VISTA ADMIN - BOSQUEJO DE LO QUE VA A SER -->
<div style="text-align:center; padding:30px;">
  <h1>🎓 Gestión de Clases </h1>
  <p style="color:#ccc;">Vista previa de lo que verán los clientes cuando lo activemos</p>
</div>

<div class="grid">
  <div class="card">
    <span class="badge a1">A1 - Principiante</span>
    <h3>Deutsch für Anfänger</h3>
    <p>Presentación, direcciones, vida en Berlín. Con material y certificado LCC.</p>
    <b>8 semanas - Virtual / Presencial</b><br>
    <a class="btn" style="background:#0f172a; color:white;" href="#">Editar Clase</a>
  </div>
  <div class="card">
    <span class="badge a2">A2 - Básico</span>
    <h3>Conversación Cotidiana</h3>
    <p>Fluidez para entrevista, supermercado, transporte.</p>
    <b>8 semanas</b><br>
    <a class="btn" style="background:#0f172a; color:white;" href="#">Editar Clase</a>
  </div>
  <div class="card">
    <span class="badge b1">B1 - Laboral</span>
    <h3>Preparación Ausbildung</h3>
    <p>CV alemán, entrevistas y alemán para trabajo.</p>
    <b>10 semanas</b><br>
    <a class="btn" style="background:#0f172a; color:white;" href="#">Editar Clase</a>
  </div>
</div>

<div style="text-align:center; margin:40px;">
  <a href="dashboard.php" style="background:white;color:black;padding:12px 25px;border-radius:25px;text-decoration:none;font-weight:bold;">← Volver al Dashboard</a>
</div>

<?php } ?>
</body>
</html>