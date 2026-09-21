<?php
include 'config/conexion.php';
session_start();

if(!isset($_SESSION['rol']) || $_SESSION['rol']!= 'admin'){
    echo '<div style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url(\'img/berlin.jpg\'); background-size:cover; height:100vh; display:flex; justify-content:center; align-items:center; color:white; font-family:Arial; text-align:center;"><div><h1>Este servicio no está disponible para este usuario</h1><br><a href="dashboard.php" style="background:white; color:black; padding:10px 20px; border-radius:5px; text-decoration:none;">Volver al Dashboard</a></div></div>';
    exit();
}

// --- USUARIOS ---
$total_usuarios = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas")->fetch_row()[0];
$total_admin = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas WHERE rol='admin'")->fetch_row()[0];
$total_cliente = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas WHERE rol='cliente'")->fetch_row()[0];

// --- SOLICITUDES - si tu tabla se llama diferente cambia aqui el nombre ---
// Prueba con: solicitudes, cotizaciones, solicitudes_cotizacion
$tabla_sol = "solicitudes";
$check = $conn->query("SHOW TABLES LIKE '$tabla_sol'");
if($check->num_rows == 0){ $tabla_sol = "cotizaciones"; }

$pendientes = $conn->query("SELECT COUNT(*) FROM $tabla_sol WHERE estado='pendiente'")->fetch_row()[0]?? 0;
$aprobadas = $conn->query("SELECT COUNT(*) FROM $tabla_sol WHERE estado='aprobada'")->fetch_row()[0]?? 0;
$entregadas = $conn->query("SELECT COUNT(*) FROM $tabla_sol WHERE estado='entregada'")->fetch_row()[0]?? 0;
$archivadas = $conn->query("SELECT COUNT(*) FROM $tabla_sol WHERE estado='archivada'")->fetch_row()[0]?? 0;
$total_sol = $conn->query("SELECT COUNT(*) FROM $tabla_sol")->fetch_row()[0]?? 0;

$lista_usuarios = $conn->query("SELECT * FROM usuarios_sistemas ORDER BY id DESC LIMIT 50");
?>
<!DOCTYPE html>
<html>
<head><title>Gestión de Reportes</title>
<style>
body{font-family:Arial; background:#f4f4f4; padding:20px;}
.card{background:white; padding:20px; border-radius:12px; box-shadow:0 2px 6px #ccc; margin-bottom:20px;}
.grid{display:grid; grid-template-columns: repeat(3, 1fr); gap:15px;}
.item{background:#222; color:white; padding:15px; border-radius:10px; text-align:center;}
.item.cliente{background:#0d6efd;}
.item.admin{background:#198754;}
.item.pendiente{background:#ffc107; color:black;}
.item.aprobada{background:#0dcaf0; color:black;}
.item.entregada{background:#198754;}
.item.archivada{background:#6c757d;}
table{width:100%; border-collapse:collapse; background:white;}
th,td{padding:10px; border:1px solid #ddd; text-align:left;}
th{background:#222; color:white;}
</style>
</head>
<body>
<h1>Gestión de Reportes</h1>
<a href="exportar_excel.php" style="background:#198754; color:white; padding:10px 20px; border-radius:8px; text-decoration:none; display:inline-block; margin-bottom:15px;">📥 Descargar Reporte en Excel</a>
<a href="dashboard.php" style="background:#555;color:white;padding:10px 20px;border-radius:20px;text-decoration:none">Volver</a>

<h3>Reporte de Usuarios</h3>
<div class="grid">
<div class="item"><h2><?php echo $total_usuarios;?></h2>Total Usuarios</div>
<div class="item admin"><h2><?php echo $total_admin;?></h2>Administradores</div>
<div class="item cliente"><h2><?php echo $total_cliente;?></h2>Clientes</div>
</div>

<h3 style="margin-top:30px;">Reporte de Solicitudes (<?php echo $tabla_sol;?>)</h3>
<div class="grid">
<div class="item"><h2><?php echo $total_sol;?></h2>Total Solicitudes</div>
<div class="item pendiente"><h2><?php echo $pendientes;?></h2>Pendientes</div>
<div class="item aprobada"><h2><?php echo $aprobadas;?></h2>Aprobadas</div>
<div class="item entregada"><h2><?php echo $entregadas;?></h2>Entregadas</div>
<div class="item archivada"><h2><?php echo $archivadas;?></h2>Archivadas</div>
</div>

<div class="card" style="margin-top:20px;">
<h3>Detalle de usuarios por rol</h3>
<table>
<tr><th>ID</th><th>Usuario</th><th>Rol</th></tr>
<?php while($u=$lista_usuarios->fetch_assoc()){?>
<tr>
<td><?php echo $u['id'];?></td>
<td><?php echo $u['nombre']?? $u['usuario']?? $u['username']?? 'Sin nombre';?></td>
<td><b><?php echo $u['ROL'] ?? $u['rol']; ?></b></td>
</tr>
<?php }?>
</table>
</div>

<br><a href="dashboard.php">Volver al Dashboard</a>
</body>
</html>