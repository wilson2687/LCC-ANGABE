<?php
session_start();
include("config/conexion.php");
if(!isset($_GET['id'])) die("Falta ID");
$id = intval($_GET['id']);

// lo marcamos como aceptada
$conn->query("UPDATE cotizaciones SET estado='aceptada' WHERE id=$id");

// y lo mandamos directo a pagar
header("Location: pagar.php?id=$id");
exit();
?>