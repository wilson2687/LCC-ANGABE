<?php
session_start();
include("config/conexion.php");
$id=intval($_GET['id']??0);
if($id>0){
  $conn->query("UPDATE cotizaciones SET estado='archivada' WHERE id=$id");
}
header("Location: admin_cotizaciones.php?filtro=entregada");
exit();
?>