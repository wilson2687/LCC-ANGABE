<?php
session_start();
include("config/conexion.php");
$mensaje = "";

if(isset($_POST['guardar'])){
    $id = intval($_POST['id']);
    $concepto = $conn->real_escape_string($_POST['concepto']);
    $valor = floatval($_POST['valor']);
    $entrega = $conn->real_escape_string($_POST['entrega']);
    $notas = $conn->real_escape_string($_POST['notas']);
    $estado = $conn->real_escape_string($_POST['estado']);
    $valor_f = "$".number_format($valor,0,'.','.')." COP";
    $detalles = "$concepto | $valor_f | $entrega | $notas";

    if($conn->query("UPDATE cotizaciones SET detalles='$detalles', estado='$estado' WHERE id=$id")){
        $mensaje = "<div style='background:#d4edda;color:#155724;padding:15px;border-radius:8px;text-align:center'><h3>✅ ¡Cotización Guardada!</h3><p>Ya quedó con formato bonito: $detalles</p><a href='admin_cotizaciones.php' style='background:#1e8c5a;color:white;padding:12px 20px;border-radius:8px;text-decoration:none;display:inline-block;margin-top:10px'>VOLVER A COTIZACIONES</a></div>";
    } else {
        $mensaje = "<div style='background:#f8d7da;padding:15px'>Error: ".$conn->error."</div>";
    }
}

$id = isset($_GET['id_solicitud']) ? intval($_GET['id_solicitud']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);
if($id==0 && $mensaje==""){ $mensaje = "Entra desde admin_cotizaciones.php dando clic en Cotizar"; $s=['id'=>0,'observaciones'=>'']; }
else { $s = $conn->query("SELECT * FROM cotizaciones WHERE id=$id")->fetch_assoc(); }
?>
<html><body style="font-family:Arial;background:#f2f2f2;padding:20px">
<div style="background:white;max-width:700px;margin:auto;padding:25px;border-radius:10px">
<?php if($mensaje!=""){ echo $mensaje; } ?>
<?php if($mensaje=="" || strpos($mensaje,'Error')!==false){?>
<h2 style="color:#1e8c5a">Cotizar #<?= $s['id']?></h2>
<p><b>Cliente pidió:</b> <?= $s['observaciones']?></p><hr>
<form method="POST">
<input type="hidden" name="id" value="<?= $s['id']?>">
<label>Concepto:</label><input type="text" name="concepto" style="width:100%;padding:12px;margin:8px 0" value="<?= htmlspecialchars($s['observaciones'])?>" required>
<label>Valor:</label><input type="number" name="valor" style="width:100%;padding:12px;margin:8px 0;border:2px solid #1e8c5a" required>
<label>Entrega:</label><input type="text" name="entrega" style="width:100%;padding:12px;margin:8px 0" value="3 días hábiles">
<label>Notas:</label><textarea name="notas" style="width:100%;padding:12px">Incluye traducción oficial</textarea>
<label>Estado:</label><select name="estado" style="width:100%;padding:12px;margin:8px 0"><option value="en_proceso">En proceso</option><option value="aceptada">Aceptada</option></select>
<button name="guardar" style="background:#1e8c5a;color:white;padding:15px;width:100%;border:none;border-radius:8px;margin-top:10px">GUARDAR COTIZACIÓN</button>
</form>
<?php }?>
</div></body></html>