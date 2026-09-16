<?php
session_start();
include("../config/conexion.php");
$id = intval($_POST['id']);
$detalles = $conn->real_escape_string($_POST['detalles']);
$estado = $conn->real_escape_string($_POST['estado']);

$conn->query("UPDATE cotizaciones SET detalles='$detalles', estado='$estado' WHERE id=$id");
header("Location: ../admin_cotizaciones.php?ok=1");
?>