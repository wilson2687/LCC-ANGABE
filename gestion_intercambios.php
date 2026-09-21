<?php
include 'config/conexion.php';
session_start();
$rol = strtolower($_SESSION['ROL'] ?? $_SESSION['rol'] ?? 'cliente');
?>
<!DOCTYPE html>
<html>
<head>
<title>Intercambios</title>
<style>
body{margin:0; min-height:100vh; background: linear-gradient(rgba(0,0,0,0.75), rgba(0,0,0,0.75)), url('imagenes/img-berlin.png'); background-size:cover; background-attachment:fixed; font-family:'Segoe UI', sans-serif; color:white;}
.center{height:100vh; display:flex; justify-content:center; align-items:center; text-align:center; padding:20px;}
.card-blanco{background:white; color:#0f172a; padding:40px 50px; border-radius:20px; box-shadow:0 20px 40px rgba(0,0,0,0.3);}
.grid{display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:20px; max-width:1100px; margin:auto; padding:20px;}
.card{background:rgba(255,255,255,0.96); color:#0f172a; border-radius:18px; padding:25px;}
.badge{display:inline-block; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:bold; background:#f3e8ff; color:#6b21a8;}
</style>
</head>
<body>
<?php if($rol != 'admin'){ ?>
<div class="center">
  <div class="card-blanco">
    <h2>🌍 Intercambios Culturales</h2>
    <div style="background:#fff3cd;padding:20px;border-radius:12px;border:1px solid #ffe69c; max-width:500px">
      Este servicio no está disponible por el momento.<br>Estamos trabajando para traerlo de vuelta pronto.
    </div><br><br>
    <a href="dashboard.php" style="background:#555;color:white;padding:10px 20px;border-radius:20px;text-decoration:none">Volver</a>
  </div>
</div>
<?php } else { ?>
<div style="text-align:center; padding:30px;">
  <h1>🌍 Gestión de Intercambios </h1>
  <p style="color:#ccc;">Propuesta visual para el módulo de intercambios</p>
</div>
<div class="grid">
  <div class="card"><span class="badge">Más Popular</span><h3>Intercambio de Estudios</h3><p>6 meses a 1 año en Alemania con familia anfitriona + curso intensivo.</p><b>Incluye Alojamiento</b></div>
  <div class="card"><span class="badge">Au Pair - 18 a 26 años</span><h3>Programa Au Pair</h3><p>Vive con familia alemana, cuida niños y gana sueldo mensual.</p><b>Berlín / Múnich</b></div>
  <div class="card"><span class="badge">Work & Study</span><h3>Intercambio Cultural</h3><p>Trabajo medio tiempo + estudio de alemán. Ideal B1/B2.</p><b>Ciudad: Berlín</b></div>
</div>
<div style="text-align:center; margin:40px;">
  <a href="dashboard.php" style="background:white;color:black;padding:12px 25px;border-radius:25px;text-decoration:none;font-weight:bold;">← Volver</a>
</div>
<?php } ?>
</body>
</html>
