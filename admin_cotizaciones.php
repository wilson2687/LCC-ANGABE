<?php
session_start();
include("config/conexion.php");

// 1. GUARDAR COTIZACION
if(isset($_POST['btn_cotizar'])){
    $id = intval($_POST['id']);
    $concepto = $conn->real_escape_string($_POST['concepto']);
    $valor = $conn->real_escape_string($_POST['valor']);
    $entrega = $conn->real_escape_string($_POST['entrega']);
    $notas = $conn->real_escape_string($_POST['notas']);
    $detalles = $conn->real_escape_string("$concepto|$valor|$entrega|$notas");
    $conn->query("UPDATE cotizaciones SET detalles='$detalles', estado='cotizada' WHERE id=$id");
    header("Location: admin_cotizaciones.php?filtro=cotizada");
    exit();
}

// 2. APROBAR PAGO
if(isset($_POST['btn_aprobar_pago'])){
    $id = intval($_POST['id']);
    $conn->query("UPDATE cotizaciones SET estado='aprobada' WHERE id=$id");
    header("Location: admin_cotizaciones.php?filtro=pagada");
    exit();
}

// 3. SUBIR TRADUCCION
if(isset($_POST['btn_subir_traduccion'])){
    $id = intval($_POST['id']);
    $carpeta = "traducciones/";
    if(!is_dir($carpeta)) mkdir($carpeta,0777,true);
    
    if(isset($_FILES['traduccion']) && $_FILES['traduccion']['error']==0){
        $nombre = "trad_".$id."_".time()."_".basename($_FILES['traduccion']['name']);
        $destino = $carpeta.$nombre;
        if(move_uploaded_file($_FILES['traduccion']['tmp_name'], $destino)){
            $conn->query("UPDATE cotizaciones SET archivo_traducido='$destino', estado='entregada' WHERE id=$id");
        }
    }
    header("Location: admin_cotizaciones.php?filtro=entregada");
    exit();
}
// ELIMINAR COTIZACION
if(isset($_POST['btn_eliminar'])){
    $id = intval($_POST['id']);
    $conn->query("DELETE FROM cotizaciones WHERE id=$id");
    header("Location: admin_cotizaciones.php?filtro=pendiente");
    exit();
}

// FILTROS

$filtro = $_GET['filtro'] ?? $_GET['f'] ?? 'pendiente';
$filtro = strtolower(trim($filtro));

// Para el ADMIN
$where = "WHERE 1=1";
if($filtro=='todas'){
  $where=" WHERE estado!='archivada'";
} elseif($filtro=='archivadas'){
  $where=" WHERE estado='archivada'";
} elseif($filtro=='cotizada'){
  $where = "WHERE LOWER(estado)='cotizada'";
} elseif($filtro=='pagada'){
  $where = "WHERE LOWER(estado)='pagada'";
} elseif($filtro=='aprobada'){
  $where = "WHERE LOWER(estado)='aprobada'";
} elseif($filtro=='entregada'){
  $where = "WHERE LOWER(estado)='entregada'";
} elseif($filtro=='pendiente'){
  $where = "WHERE (LOWER(estado)='pendiente' OR estado='' OR estado IS NULL)";
}
$res = $conn->query("SELECT c.id AS cid, c.*, TRIM(CONCAT_WS(' ', u.nombre, u.apellido)) AS cliente_nombre, u.correo AS cliente_correo FROM cotizaciones c LEFT JOIN usuarios_sistemas u ON u.id = c.usuario_id $where ORDER BY c.id DESC");
?>
<!DOCTYPE html>
<html><head><meta charset="UTF-8"><title>Admin Cotizaciones - LCC ANGABE</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Arial;background:#f1f1f1;padding:15px;margin:0}
.card{background:white;padding:15px;border-radius:10px;margin-bottom:12px;box-shadow:0 2px 5px rgba(0,0,0,0.1)}
.btn{padding:8px 14px;border-radius:6px;color:white;text-decoration:none;display:inline-block;font-weight:bold;margin:3px;border:none;cursor:pointer}
.b-blue{background:#1565c0} .b-green{background:#2e7d32} .b-orange{background:#ef6c00} .b-gray{background:#555} .b-dark{background:#1b5e20}
input,textarea,select{width:100%;padding:10px;margin:4px 0;box-sizing:border-box;border:1px solid #ccc;border-radius:6px}
.active{outline:3px solid #000 !important}
</style>
</head><body>

<!-- BOTONES PARA REGRESAR -->
<a href="javascript:history.go(-1)" style="display:inline-block;padding:10px 15px;background:#ddd;border-radius:8px;text-decoration:none;color:#333;font-weight:bold;margin-bottom:10px;">← Volver atrás</a>

<a href="dashboard.php" class="btn b-gray">🏠 Dashboard</a>

<h3 style="margin:15px 0">Admin Cotizaciones - <?= strtoupper($filtro) ?> (<?= $res->num_rows ?>)</h3>

<!-- BOTONES FILTRO -->
<a href="?filtro=pendiente" class="btn <?= $filtro=='pendiente'?'b-orange active':'b-blue' ?>">Pendientes</a> 
<a href="?filtro=cotizada" class="btn <?= $filtro=='cotizada'?'b-orange active':'b-green' ?>">Cotizadas</a>
<a href="?filtro=pagada" class="btn <?= $filtro=='pagada'?'b-orange active':'b-dark' ?>">💰 Pagadas</a>
<a href="?filtro=aprobada" class="btn <?= $filtro=='aprobada'?'b-orange active':'b-blue' ?>">Aprobadas</a>
<a href="?filtro=entregada" class="btn <?= $filtro=='entregada'?'b-orange active':'b-gray' ?>">Entregadas</a>
<a href="?f=archivadas" style="padding:8px 12px;background:<?= $filtro=='archivadas'?'#555':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin-left:4px">📦 Archivadas</a>
<hr>

<?php if($res->num_rows==0): ?>
<div class="card" style="text-align:center;color:#777;padding:30px">No hay cotizaciones en <b><?= $filtro ?></b></div>
<?php endif; ?>

<?php while($c=$res->fetch_assoc()):?>
<div class="card">
<b>ID #<?= $c['cid']?>  - <?= $c['fecha']??''?> - <span style="text-transform:uppercase;color:#1565c0"><?= $c['estado']?></span></b><br>
<div style="background:#fff8e1;padding:8px;border-radius:6px;margin:8px 0;border-left:4px solid #ff9800">
<b>👤 Cliente:</b> <?= htmlspecialchars($c['cliente_nombre'] ?: 'Sin nombre ID '.$c['usuario_id'])?><br>
<b>📧 Correo:</b> <?= htmlspecialchars($c['cliente_correo'] ?: 'Sin correo')?> - ID Usuario: <?= $c['usuario_id']?>
</div>
<b>Cliente pidió:</b> <?= htmlspecialchars($c['observaciones'])?><br><br>
<form method="POST" style="margin-top:10px;border-top:1px solid #ccc;padding-top:10px" onsubmit="return confirm('¿ELIMINAR cotización #<?= $c['cid'] ?>? No se puede recuperar');">
    <input type="hidden" name="id" value="<?= $c['cid']?>">
    <button name="btn_eliminar" class="btn b-red" style="width:100%;padding:12px;font-size:16px;background:#e53935;color:white;border:none;border-radius:6px;cursor:pointer">🗑 ELIMINAR COTIZACION</button>
</form>

<div style="background:#e3f2fd;padding:10px;border-left:5px solid #1565c0;border-radius:6px">
<b>Archivo cliente:</b><br><br>
<?php
$arch=$c['archivos']??''; $ok=false;
if($arch && $arch!='[]'){
 $lista=json_decode($arch,true);
 if(is_array($lista)){
  foreach($lista as $a){
   $a=trim($a); $link=$a;
   if(!empty($a)) { echo "<a href='$link' target='_blank' class='btn b-blue'>📄 Ver Archivo</a> $a<br><br>"; $ok=true; }
  }
 }
}
$carpeta="uploads/cotizacion_".$c['id']."/";
if(!$ok && is_dir($carpeta)){ foreach(glob($carpeta."*") as $f){ echo "<a href='$f' target='_blank' class='btn b-blue'>📄 Ver</a> $f<br><br>"; $ok=true; } }
if(!$ok) echo "❌ Sin archivo - BD: ".htmlspecialchars($arch);
?>
</div>

<?php if(strtolower($c['estado'])=='pendiente'):?>
<form method="POST" style="margin-top:10px;border-top:1px solid #ccc;padding-top:10px">
<input type="hidden" name="id" value="<?= $c['cid']?>">
<input name="concepto" placeholder="Concepto (ej. Traducción oficial)" required>
<input name="valor" placeholder="Valor ej $120.000" required>
<input name="entrega" placeholder="Entrega ej. 24 horas">
<textarea name="notas" placeholder="Incluye ej. Sello, Firma..."></textarea>
<button name="btn_cotizar" class="btn b-green" style="width:100%;padding:12px;font-size:16px">💾 GUARDAR COTIZACION</button>
</form>
<?php else:?>
<div style="background:#e8f5e9;padding:10px;margin-top:10px;border-radius:6px;border-left:5px solid #2e7d32">
<b>✅ Cotización:</b> <?= htmlspecialchars($c['detalles'])?>
</div>
<?php endif; ?>

<?php if(strtolower($c['estado'])=='pagada'):?>
<div style="background:#fff8e1;padding:15px;margin-top:10px;border-left:5px solid #ef6c00;border-radius:8px">
<b>💰 PAGADA - Esperando aprobación</b><br><br>
<?php
$rp = $conn->query("SELECT * FROM pagos WHERE cotizacion_id=".$c['id']." ORDER BY id DESC LIMIT 1");
if($rp && $rp->num_rows>0){
    $pago = $rp->fetch_assoc();
    echo "Método: <b>".htmlspecialchars($pago['metodo'])."</b><br>";
    echo "Comprobante: ".$pago['comprobante']."<br><br>";
    echo "<a href='comprobantes/".$pago['comprobante']."' target='_blank' class='btn b-orange'>📸 Ver Comprobante</a><br><br>";
} else {
    foreach(glob("comprobantes/*".$c['id']."*") as $comp){ echo "<a href='$comp' target='_blank' class='btn b-orange'>Ver $comp</a><br>"; }
}
?>
<form method="POST" style="margin-top:10px"><input type="hidden" name="id" value="<?= $c['cid']?>"><button name="btn_aprobar_pago" class="btn b-green" style="width:100%;padding:12px;background:#2e7d32;font-size:15px">✅ APROBAR PAGO Y EMPEZAR</button></form>
</div>
<?php endif; ?>

<?php if(strtolower($c['estado'])=='aprobada'):?>
<div style="background:#e8f5e9;padding:15px;margin-top:10px;border-left:5px solid #2e7d32;border-radius:8px">
<b>✅ PAGO APROBADO - Subir traducción</b><br><br>
<form method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?= $c['cid']?>">
<label><b>Adjuntar documento traducido (PDF, Word):</b></label>
<input type="file" name="traduccion" required style="margin:10px 0">
<button name="btn_subir_traduccion" class="btn b-blue" style="width:100%;padding:12px;background:#1565c0">📤 SUBIR Y ENTREGAR AL CLIENTE</button>
</form>
</div>
<?php endif; ?>

<?php if(strtolower($c['estado'])=='entregada'):?>
<div style="background:#e3f2fd;padding:15px;margin-top:10px;border-left:5px solid #1565c0;border-radius:8px">
<b>📦 ENTREGADA</b><br><br>

<?php
// COMPROBANTE VIENE DE TABLA PAGOS - como en tu foto de phpMyAdmin
$rp2 = $conn->query("SELECT comprobante FROM pagos WHERE cotizacion_id=".$c['cid']." ORDER BY id DESC LIMIT 1");
if($rp2 && $rp2->num_rows>0){
  $pg = $rp2->fetch_assoc();
  $comp = $pg['comprobante'];
  // tu comprobante en la BD es: 1798793599_32_WhatsApp Image...
  // esta en carpeta comprobantes/
  echo "<a href='comprobantes/".$comp."' target='_blank' class='btn b-orange' style='background:#ff9800'>💳 Ver Comprobante</a> ";
  echo "<a href='../comprobantes/".$comp."' target='_blank' class='btn b-orange' style='background:#ff9800'>💳</a><br><small>".$comp."</small><br><br>";
}
?>

<?php if(!empty($c['archivo_traducido'])): ?>
<a href="<?= $c['archivo_traducido'] ?>" target="_blank" class="btn b-blue">📄 Ver Traducción Entregada</a><br><small><?= $c['archivo_traducido'] ?></small>
<?php
if(strtolower($c['estado']??$c['estado_traduccion']??'')=='entregada'){
  $fecha_ref = $c['fecha_entrega'] ?? $c['fecha_actualizacion'] ?? $c['fecha'] ?? $c['created_at'] ?? date('Y-m-d');
  $dias = floor((time() - strtotime($fecha_ref))/86400);
  if($dias>=0){ // por ahora 0 dias para que lo pruebes, luego lo cambias a 5
    echo "<a href='archivar_cotizacion.php?id={$c['id']}' onclick=\"return confirm('¿Archivar cotización #{$c['id']}? Se va a Archivadas pero el cliente la seguirá viendo.')\" style='display:inline-block;background:#555;color:white;padding:8px 14px;border-radius:8px;text-decoration:none;font-weight:bold;margin:6px 2px'>📦 Archivar</a> <small style='color:#555'>Hace $dias días</small>";
  }
}
?>

<?php endif; ?>
</div>
<?php endif; ?>

</div>
<?php endwhile;?>
</body></html>