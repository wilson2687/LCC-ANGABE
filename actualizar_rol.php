<?php
include 'config/conexion.php';
session_start();
if($_SESSION['rol']!='admin') die("No autorizado");
$id = $_POST['id'];
$rol = $_POST['rol'];
$conn->query("UPDATE usuarios_sistemas SET ROL='$rol' WHERE id=$id");
header("Location: gestion_admin.php");
?>