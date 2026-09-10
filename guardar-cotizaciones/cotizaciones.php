<?php
include __DIR__. '/../config/conexion.php';
session_start();

// Tu conexion se llama $conn, $con o $conexion, esto lo detecta solo
if (isset($conexion)) { $db = $conexion; }
elseif (isset($conn)) { $db = $conn; }
elseif (isset($con)) { $db = $con; }
elseif (isset($mysqli)) { $db = $mysqli; }
else { die("No encontre la variable de conexion en config/conexion.php"); }

$observaciones = $_POST['observaciones']?? '';
$detalles = $_POST['detalles']?? '';
$usuario_id = $_SESSION['id']?? 1;

$directorio = __DIR__. '/../uploads/cotizaciones/';
$directorio_bd = "uploads/cotizaciones/";
if (!file_exists($directorio)) {
    mkdir($directorio, 0777, true);
}

$archivos_guardados = [];

function guardarArch($inputName, $dirFisico, $dirBD, &$lista){
    if(isset($_FILES[$inputName]) &&!empty($_FILES[$inputName]['name'][0])){
        for($i=0; $i<count($_FILES[$inputName]['name']); $i++){
            if($_FILES[$inputName]['error'][$i]==0){
                $nombre = time()."_".rand(1000,9999)."_".basename($_FILES[$inputName]['name'][$i]);
                if(move_uploaded_file($_FILES[$inputName]['tmp_name'][$i], $dirFisico.$nombre)){
                    $lista[] = $dirBD.$nombre;
                }
            }
        }
    }
}

guardarArch('documentos', $directorio, $directorio_bd, $archivos_guardados);
guardarArch('documentos2', $directorio, $directorio_bd, $archivos_guardados);

$archivos_json = $db->real_escape_string(json_encode($archivos_guardados));
$obs = $db->real_escape_string($observaciones);
$det = $db->real_escape_string($detalles);

$sql = "INSERT INTO cotizaciones (usuario_id, observaciones, detalles, archivos, fecha) VALUES ('$usuario_id', '$obs', '$det', '$archivos_json', NOW())";

if ($db->query($sql)) {
    header("Location: /LCC-ANGABE/dashboard.php?ok=1");
    exit();
} else {
    echo "Error BD: ". $db->error;
}
?>