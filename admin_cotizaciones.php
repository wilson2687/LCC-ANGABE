<?php
include 'config/conexion.php';
session_start();
if($_SESSION['rol'] != 'admin'){ die("Acceso solo admin"); }
$res = $conn->query("SELECT c.*, u.nombre as nombre_usuario, u.correo FROM cotizaciones c LEFT JOIN usuarios_sistemas u ON c.usuario_id = u.id ORDER BY c.id DESC");
?>
<!DOCTYPE html>
<html><head><style>
body{font-family:Arial; background: url('img/berlin.jpg'); background-size:cover; padding:20px;}
.card{background:white; padding:20px; border-radius:12px; max-width:1100px; margin:auto;}
.badge{padding:5px 10px; border-radius:15px; color:white; font-weight:bold; font-size:12px;}
.pendiente{background:orange} .aceptada{background:#1e8c5a} .rechazada{background:red} .en_proceso{background:#0d6efd}
table{width:100%; border-collapse:collapse;} th{background:#1e8c5a; color:white; padding:10px;} td{padding:8px; border-bottom:1px solid #ddd;}
</style></head><body>
<div class="card">
<h2>📋 Gestión de Solicitudes - ADMIN ANGABE</h2>
<?php if(isset($_GET['estado_ok'])) echo "<div style='background:#d4edda; padding:10px; border-radius:5px; margin-bottom:10px;'>✅ Estado actualizado</div>"; ?>
<table>
<tr><th>ID</th><th>Usuario</th><th>Observaciones</th><th>Estado</th><th>Cambiar Estado</th><th>Fecha</th></tr>
<?php while($r=$res->fetch_assoc()): ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['nombre_usuario'] ?></td>
<td><?= substr($r['observaciones'],0,60) ?>...</td>
<td><span class="badge <?= $r['estado'] ?>"><?= strtoupper($r['estado']) ?></span></td>
<td>
<form method="POST" action="actualizar_estado.php">
<input type="hidden" name="id" value="<?= $r['id'] ?>">
<select name="estado" style="padding:5px; border-radius:5px;">
<option value="pendiente" <?= $r['estado']=='pendiente'?'selected':'' ?>>Pendiente</option>
<option value="aceptada" <?= $r['estado']=='aceptada'?'selected':'' ?>>Aceptada</option>
<option value="en_proceso" <?= $r['estado']=='en_proceso'?'selected':'' ?>>En Proceso</option>
<option value="rechazada" <?= $r['estado']=='rechazada'?'selected':'' ?>>Rechazada</option>
</select>
<button style="background:#0d6efd; color:white; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">Actualizar</button>
</form>
</td>
<td><?= $r['fecha'] ?></td>
</tr>
<?php endwhile; ?>
</table>
<br><a href="dashboard.php" style="background:#1e8c5a; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">Volver al Dashboard</a>
</div>
</body>
</html>