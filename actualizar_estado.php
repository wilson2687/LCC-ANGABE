<?php
include 'config/conexion.php';
session_start();
if($_SESSION['rol'] != 'admin') die("Solo admin");
$id = $_POST['id'];
$estado = $_POST['estado'];
$conn->query("UPDATE cotizaciones SET estado='$estado' WHERE id=$id");
header("Location: admin_cotizaciones.php?estado_ok=1");