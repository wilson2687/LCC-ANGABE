<?php
session_start();
require_once('config/conexion.php'); // como está en la misma carpeta php/

if(!isset($_SESSION['rol'])){
    header("Location:index.php");
    exit();
}

$rol = strtolower($_SESSION['rol']);

if($rol == 'admin'){
    // Si es ADMIN lo mandamos a la gestión de TODOS
    header("Location: gestion_admin.php");
    exit();
} else {
    // Si es CLIENTE / USUARIO lo mandamos a gestionar solo lo suyo
    header("Location: mi_perfil.php");
    exit();
}

?>