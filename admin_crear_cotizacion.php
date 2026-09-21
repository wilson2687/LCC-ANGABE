<?php
session_start();
include("config/conexion.php");
$id = intval($_GET['id'] ?? $_POST['id'] ?? 0);
$s = $conn->query("SELECT * FROM cotizaciones WHERE id=$id")->fetch_assoc();

if(isset($_POST['guardar'])){
    $detalles = $_POST['concepto']." | $".number_format($_POST['valor'],0,'.','.')." COP | ".$_POST['entrega']." | ".$_POST['notas'];
    // NO TOCAMOS usuario_id, solo detalles y estado
    $stmt = $conn->prepare("UPDATE cotizaciones SET detalles=?, estado='cotizada' WHERE id=?");
    $stmt->bind_param("si", $detalles, $id);
    $stmt->execute();
    header("Location: admin_cotizaciones.php?filtro=cotizada");
    exit;
}
?>
<form method="POST">
<input type="hidden" name="id" value="<?=$id?>">
Concepto: <input name="concepto" value="<?=$s['observaciones']?>" style="width:100%"><br>
Valor: <input name="valor" type="number" required style="width:100%"><br>
Entrega: <input name="entrega" value="3 dias"><br>
Notas: <textarea name="notas" style="width:100%">Incluye oficial</textarea><br>
<button name="guardar" style="background:#1e8c5a;color:#fff;padding:12px;width:100%">GUARDAR COTIZADA</button>
</form>