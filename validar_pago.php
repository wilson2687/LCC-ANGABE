<?php
include("config/conexion.php");
$id = intval($_GET['id']);
$accion = $_GET['accion'];

if($accion == 'aprobar'){
    $conn->query("UPDATE cotizaciones SET estado='EN_PROCESO' WHERE id=$id");
} else {
    $conn->query("UPDATE cotizaciones SET estado='ACEPTADA' WHERE id=$id");
}

header("Location: admin_cotizaciones.php");
exit;
?>