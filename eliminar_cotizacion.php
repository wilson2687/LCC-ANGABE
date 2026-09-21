<?php
if(session_status()==PHP_SESSION_NONE) session_start();
include("config/conexion.php");
$id=intval($_GET['id']??0);
if($id>0) $conn->query("DELETE FROM cotizaciones WHERE id=$id");
header("Location: mis_cotizaciones.php?f=".$_GET['f']??'pendientes');
?>