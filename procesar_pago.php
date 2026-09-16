<?php
session_start();
if(file_exists("config/conexion.php")) include("config/conexion.php");
elseif(file_exists("php/config/conexion.php")) include("php/config/conexion.php");
else include("config/conexion.php");

$id = intval($_POST['id'] ?? 0);
$metodo = $conn->real_escape_string($_POST['metodo'] ?? 'Nequi');

$carpeta = "comprobantes/";
if(!is_dir($carpeta)) mkdir($carpeta,0777,true);

$nom = "";
if(isset($_FILES['comprobante']) && $_FILES['comprobante']['error']==0){
    $nom = time()."_".$id."_".basename($_FILES['comprobante']['name']);
    move_uploaded_file($_FILES['comprobante']['tmp_name'], $carpeta.$nom);
    
    // si tienes tabla pagos, lo guarda ahí
    $conn->query("INSERT INTO pagos (cotizacion_id, metodo, comprobante) VALUES ($id, '$metodo', '$nom')");
}

// marca la cotizacion como pagada
$conn->query("UPDATE cotizaciones SET estado='pagada' WHERE id=$id");

header("Location: dashboard.php?pagado=1");
exit();
?>