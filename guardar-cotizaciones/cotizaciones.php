<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);

// busca la conexion donde la tengas
if(file_exists("../config/conexion.php")) require_once("../config/conexion.php");
elseif(file_exists("../../config/conexion.php")) require_once("../../config/conexion.php");
elseif(file_exists("config/conexion.php")) require_once("config/conexion.php");
else{ die("No encuentro conexion.php"); }

if(session_status()===PHP_SESSION_NONE){ session_start(); }
$uid = intval($_SESSION['id'] ?? $_SESSION['usuario_id'] ?? $_SESSION['user_id'] ?? $_SESSION['id_usuario'] ?? 0);
$obs = $conn->real_escape_string($_POST['observaciones'] ?? $_POST['obs'] ?? 'Sin observaciones');
$det = $conn->real_escape_string($_POST['detalles'] ?? '');

// 1. Inserta primero para obtener el ID - CON archivos vacío
$conn->query("INSERT INTO cotizaciones (usuario_id, observaciones, detalles, estado, fecha, archivos) VALUES ($uid, '$obs', '$det', 'pendiente', NOW(), '[]')");
$id = $conn->insert_id;

$carpeta = "../uploads/cotizacion_$id/";
$carpeta_bd = "uploads/cotizacion_$id/";
if(!is_dir($carpeta)) mkdir($carpeta, 0777, true);

$rutas = [];

// 2. Guarda archivos (tu mismo codigo pero guardando la ruta)
foreach(['documentos','documentos2'] as $campo){
  if(isset($_FILES[$campo])){
    foreach($_FILES[$campo]['tmp_name'] as $k => $tmp){
      if($tmp && $_FILES[$campo]['error'][$k]==0){
        $name = time()."_".basename($_FILES[$campo]['name'][$k]);
        $name = preg_replace('/[^a-zA-Z0-9._-]/','_', $name);
        if(move_uploaded_file($tmp, $carpeta.$name)){
          $rutas[] = $carpeta_bd.$name;
        }
      }
    }
  }
}

// Si tu form tiene name="archivo" en singular
if(isset($_FILES['archivo']) && $_FILES['archivo']['error']==0){
  $name = time()."_".basename($_FILES['archivo']['name']);
  $name = preg_replace('/[^a-zA-Z0-9._-]/','_', $name);
  if(move_uploaded_file($_FILES['archivo']['tmp_name'], $carpeta.$name)){
    $rutas[] = $carpeta_bd.$name;
  }
}

// 3. ESTA ES LA LINEA QUE TE FALTA - ACTUALIZA LA BD CON EL ARCHIVO
if(!empty($rutas)){
  $json = json_encode($rutas, JSON_UNESCAPED_SLASHES);
  $json = $conn->real_escape_string($json);
  $conn->query("UPDATE cotizaciones SET archivos='$json' WHERE id=$id");
}

header("Location: ../dashboard.php?ok=1");
exit();
?>