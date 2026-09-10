<?php
include 'config/conexion.php';
session_start();
if(!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin'){ die("Acceso solo admin"); }

$res = $conn->query("SELECT * FROM usuarios_sistemas ORDER BY id DESC");
?>
<!DOCTYPE html>
<html><head><style>
body{font-family:Arial; background:url('img/berlin.jpg'); background-size:cover; padding:20px;}
.card{background:white; padding:20px; border-radius:12px; max-width:1100px; margin:auto;}
table{width:100%; border-collapse:collapse;} th{background:#1e8c5a; color:white; padding:10px;} td{padding:8px; border-bottom:1px solid #ddd; text-align:center;}
.badge{padding:5px 10px; border-radius:15px; color:white; font-size:12px;}
.admin{background:#0d6efd;} .cliente{background:#6c757d;}
</style></head><body>
<div class="card">
<h2>👥 Gestión de Usuarios - ADMIN ANGABE</h2>
<table>
<tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Fecha</th><th>Acción</th></tr>
<?php while($r=$res->fetch_assoc()): ?>
<tr>
<td><?= $r['id'] ?></td>
<td><?= $r['nombre']." ".$r['apellido'] ?></td>
<td><?= $r['correo'] ?></td>
<td><span class="badge <?= $r['ROL']=='admin'?'admin':'cliente' ?>"><?= strtoupper($r['ROL']) ?></span></td>
<td><?= $r['fecha_registro'] ?></td>
<td>
<form method="POST" action="actualizar_rol.php" style="display:inline;">
<input type="hidden" name="id" value="<?= $r['id'] ?>">
<select name="rol"><option value="cliente" <?= $r['ROL']=='cliente'?'selected':'' ?>>Cliente</option><option value="admin" <?= $r['ROL']=='admin'?'selected':'' ?>>Admin</option></select>
<button style="background:#0d6efd; color:white; border:none; padding:5px 8px; border-radius:5px;">Cambiar</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>
<br>
<a href="dashboard.php" style="background:#1e8c5a; color:white; padding:10px 15px; text-decoration:none; border-radius:6px;">Volver al Dashboard</a>
<a href="admin_cotizaciones.php" style="background:#0d6efd; color:white; padding:10px 15px; text-decoration:none; border-radius:6px; margin-left:10px;">Ver Solicitudes</a>
</div>
</body></html>