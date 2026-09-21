<?php
include 'config/conexion.php';
session_start();

if(!isset($_SESSION['rol']) || strtolower($_SESSION['rol'])!= 'admin'){
    header("Location: dashboard.php");
    exit();
}

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_usuarios_".date("Y-m-d").".xls");
header("Pragma: no-cache");

$total_usuarios = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas")->fetch_row()[0];
$total_admin = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas WHERE ROL='admin'")->fetch_row()[0];
$total_cliente = $conn->query("SELECT COUNT(*) FROM usuarios_sistemas WHERE ROL='cliente'")->fetch_row()[0];

$lista = $conn->query("SELECT * FROM usuarios_sistemas ORDER BY id DESC");
?>
<table border="1">
<tr><th colspan="4">REPORTE DE USUARIOS - LCC ANGABE - <?php echo date("d/m/Y");?></th></tr>
<tr><th>Total Usuarios</th><th>Total Admin</th><th>Total Cliente</th><th></th></tr>
<tr><td><?php echo $total_usuarios;?></td><td><?php echo $total_admin;?></td><td><?php echo $total_cliente;?></td><td></td></tr>
<tr></tr>
<tr><th>ID</th><th>Nombre / Usuario</th><th>Correo</th><th>ROL</th></tr>
<?php while($u=$lista->fetch_assoc()){?>
<tr>
<td><?php echo $u['id'];?></td>
<td><?php echo $u['nombre']?? $u['usuario']?? $u['username'];?></td>
<td><?php echo $u['correo']?? $u['email']?? '';?></td>
<td><?php echo $u['ROL']?? $u['rol'];?></td>
</tr>
<?php }?>
</table>