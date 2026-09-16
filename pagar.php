<?php
session_start();

// busca tu conexion donde esté
if(file_exists("config/conexion.php")){
    include("config/conexion.php");
} elseif(file_exists("php/config/conexion.php")){
    include("php/config/conexion.php");
} else {
    include("config/conexion.php");
}

$id = intval($_GET['id']?? 0);
$res = $conn->query("SELECT * FROM cotizaciones WHERE id=$id");
$c = $res->fetch_assoc();
if(!$c){ die("Cotización no encontrada"); }

$partes = explode("|", $c['detalles']?? '');
$concepto = trim($partes[0]?? 'Cotización');
$valor = trim($partes[1]?? 'Por definir');
$entrega = trim($partes[2]?? '');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Pagar #<?= $id?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family:Arial;background:#f2f2f2;padding:20px;">
<div style="background:white;max-width:480px;margin:auto;padding:25px;border-radius:12px;text-align:center;">
<h2 style="color:#1e8c5a;margin-top:0;">Pagar Cotización #<?= $id?></h2>
<p style="font-size:15px;"><b><?= htmlspecialchars($concepto)?></b><br>
<span style="font-size:24px;color:#1e8c5a;font-weight:bold;"><?= htmlspecialchars($valor)?></span><br>
<small><?= htmlspecialchars($entrega)?></small></p>

<hr>
<p style="text-align:left;">Transfiere a:<br>
<b>Nequi:</b> 300 123 4567<br>
<b>Bancolombia Ahorros:</b> 123-456789-12<br>
<b>A nombre de:</b> LCC ANGABE</p>

<form action="procesar_pago.php" method="POST" enctype="multipart/form-data" style="text-align:left;">
<input type="hidden" name="id" value="<?= $id?>">
<label>Método de pago</label>
<select name="metodo" required style="width:100%;padding:10px;margin:6px 0 12px 0;border-radius:6px;border:1px solid #ccc;">
<option value="Nequi">Nequi</option>
<option value="PSE">PSE</option>
<option value="Bancolombia">Bancolombia</option>
<option value="Daviplata">Daviplata</option>
</select>

<label>Subir comprobante (foto o PDF)</label>
<input type="file" name="comprobante" required style="width:100%;margin:8px 0 15px 0;">

<button type="submit" style="width:100%;padding:14px;background:#1e8c5a;color:white;border:none;border-radius:8px;font-weight:bold;font-size:16px;cursor:pointer;">
✅ CONFIRMAR PAGO
</button>
</form>

<a href="dashboard.php" style="display:block;margin-top:15px;color:#555;text-decoration:none;">← Volver</a>
</div>
</body>
</html>