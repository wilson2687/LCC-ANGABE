<?php
session_start();
require_once('../config/conexion.php');

if(!isset($_SESSION['usuario'])){
    header("Location: ../index.php");
    exit();
}

$usuario_id = intval($_SESSION['id'] ?? $_SESSION['usuario_id'] ?? 0);
$observaciones = $conn->real_escape_string($_POST['observaciones'] ?? '');
$detalles = $conn->real_escape_string($_POST['detalles'] ?? '');
$estado = 'pendiente';

// 1. INSERTA PRIMERO VACÍO PARA CONSEGUIR EL ID
$sql = "INSERT INTO cotizaciones (usuario_id, observaciones, detalles, estado, fecha, archivos) VALUES ($usuario_id, '$observaciones', '$detalles', '$estado', NOW(), '[]')";

if($conn->query($sql)){
    $cotizacion_id = $conn->insert_id;

    // CREA CARPETA PARA ESTA COTIZACION
    $carpeta = "../uploads/cotizacion_$cotizacion_id/";
    $carpeta_bd = "uploads/cotizacion_$cotizacion_id/"; // ruta para la BD sin ../
    if(!is_dir($carpeta)){
        mkdir($carpeta, 0777, true);
    }

    $rutas_guardadas = [];

    // Guarda primer grupo de archivos
    if(isset($_FILES['documentos'])){
        foreach($_FILES['documentos']['tmp_name'] as $k=>$tmp){
            if(!empty($tmp) && $_FILES['documentos']['error'][$k]==0){
                $nombre = basename($_FILES['documentos']['name'][$k]);
                $nombre = preg_replace('/[^a-zA-Z0-9._-]/','_', $nombre);
                $nombre_final = time()."_".$nombre;
                if(move_uploaded_file($tmp, $carpeta.$nombre_final)){
                    $rutas_guardadas[] = $carpeta_bd.$nombre_final;
                }
            }
        }
    }
    // Guarda segundo grupo de archivos
    if(isset($_FILES['documentos2'])){
        foreach($_FILES['documentos2']['tmp_name'] as $k=>$tmp){
            if(!empty($tmp) && $_FILES['documentos2']['error'][$k]==0){
                $nombre = basename($_FILES['documentos2']['name'][$k]);
                $nombre = preg_replace('/[^a-zA-Z0-9._-]/','_', $nombre);
                $nombre_final = time()."_".$nombre;
                if(move_uploaded_file($tmp, $carpeta.$nombre_final)){
                    $rutas_guardadas[] = $carpeta_bd.$nombre_final;
                }
            }
        }
    }

    // 2. AHORA SI ACTUALIZA LA COLUMNA ARCHIVOS CON LAS RUTAS REALES
    if(!empty($rutas_guardadas)){
        $json = json_encode($rutas_guardadas, JSON_UNESCAPED_SLASHES);
        $json_sql = $conn->real_escape_string($json);
        $conn->query("UPDATE cotizaciones SET archivos='$json_sql' WHERE id=$cotizacion_id");
    }

    header("Location: ../dashboard.php?ok=1");
    exit();
} else {
    echo "Error al guardar: ".$conn->error;
}
?>