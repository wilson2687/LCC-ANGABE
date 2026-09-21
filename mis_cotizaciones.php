<?php
if(session_status()==PHP_SESSION_NONE) session_start();
include("config/conexion.php");

$uid = intval($_SESSION['id_usuario']?? $_SESSION['id']?? $_SESSION['usuario_id']?? $_SESSION['user_id']?? 0);
if($uid==0){ header("Location: login.php"); exit(); }

$filtro = $_GET['f']??'todas';
$where = "WHERE usuario_id=$uid";
if($filtro!='todas'){
  if($filtro=='pendientes') $where.=" AND estado='pendiente'";
  if($filtro=='cotizadas') $where.=" AND estado IN ('cotizada','cotizado','aceptada')";
  if($filtro=='pagadas') $where.=" AND estado IN ('pagada','pagado','en_proceso')";
  if($filtro=='aprobadas') $where.=" AND estado='aprobada'";
  if($filtro=='entregadas') $where.=" AND estado IN ('entregada','archivada')";
}
$res = $conn->query("SELECT * FROM cotizaciones $where ORDER BY id DESC");
?>
<div style="font-family:Arial;max-width:800px;margin:10px auto;padding:10px">
<h2 style="color:#1e8c5a;text-align:center">Mis Cotizaciones</h2>
<div style="text-align:center;margin-bottom:10px">
<a href="dashboard.php" style="padding:10px 18px;background:#1e8c5a;color:white;border-radius:8px;text-decoration:none;font-weight:bold">🏠 Volver al Dashboard</a>
</div>
<div style="text-align:center;margin-bottom:15px">
<a href="?f=todas" style="padding:8px 12px;background:<?= $filtro=='todas'?'#1e8c5a':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Todas</a>
<a href="?f=pendientes" style="padding:8px 12px;background:<?= $filtro=='pendientes'?'#ff9800':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Pendientes</a>
<a href="?f=cotizadas" style="padding:8px 12px;background:<?= $filtro=='cotizadas'?'#1565c0':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Cotizadas</a>
<a href="?f=pagadas" style="padding:8px 12px;background:<?= $filtro=='pagadas'?'#2e7d32':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Pagadas</a>
<a href="?f=aprobadas" style="padding:8px 12px;background:<?= $filtro=='aprobadas'?'#6a1b9a':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Aprobadas</a>
<a href="?f=entregadas" style="padding:8px 12px;background:<?= $filtro=='entregadas'?'#000':'#ccc'?>;color:white;border-radius:20px;text-decoration:none;margin:2px;display:inline-block">Entregadas</a>
</div>

<?php while($c=$res->fetch_assoc()):
$estado=strtolower(trim($c['estado']??''));
$fecha=$c['fecha']?? $c['fecha_solicitud']?? $c['created_at']??'';
?>
<div style="background:white;border-radius:12px;padding:15px;margin-bottom:12px;box-shadow:0 2px 8px #ccc;border-left:6px solid #1e8c5a">
<b>ID #<?= $c['id']?> - <?= strtoupper($estado)?></b><br>
<small>📅 <?= htmlspecialchars($fecha)?></small><br>
<?= htmlspecialchars($c['observaciones']??'')?><br><br>

<?php
// --- 1. BOTON ORIGINAL SIEMPRE VISIBLE ---
if(!empty($c['archivos']) && $c['archivos']!='[]'){
  $l=json_decode($c['archivos'],true);
  if(is_array($l)){ foreach($l as $a){ if($a) echo "<a href='$a' target='_blank' style='background:#1565c0;color:white;padding:6px 10px;border-radius:6px;text-decoration:none;margin:2px;display:inline-block'>📄 Original</a>"; } }
} else if(!empty($c['archivo'])){
  echo "<a href='".$c['archivo']."' target='_blank' style='background:#1565c0;color:white;padding:6px 10px;border-radius:6px;text-decoration:none;margin:2px;display:inline-block'>📄 Original</a>";
}

// --- 2. BOTON COMPROBANTE ---
$comp_q = $conn->query("SELECT comprobante FROM pagos WHERE cotizacion_id=".$c['id']." ORDER BY id DESC LIMIT 1");
$comp = "";
if($comp_q && $comp_q->num_rows>0){ $tmp=$comp_q->fetch_assoc(); $comp = $tmp['comprobante']; }
if(!empty($comp) && $comp!='[]'){
  $l2=json_decode($comp,true);
  if(is_array($l2)){ foreach($l2 as $b){ if($b){ $ruta=(strpos($b,'comprobantes/')!==false)?$b:'comprobantes/'.$b; echo " <a href='$ruta' target='_blank' style='background:#ff9800;color:white;padding:6px 10px;border-radius:6px;text-decoration:none;margin:2px;display:inline-block'>💳 Comprobante</a>"; } } }
  else { $ruta=(strpos($comp,'comprobantes/')!==false)?$comp:'comprobantes/'.$comp; echo " <a href='$ruta' target='_blank' style='background:#ff9800;color:white;padding:6px 10px;border-radius:6px;text-decoration:none'>💳 Comprobante</a>"; }
}
?>
<br><br>
<?php if(in_array($estado,['cotizada','cotizado','aceptada'])){ $p=explode("|",$c['detalles']??''); $v=$p[1]??''; echo "<b>Valor: $v</b><br><a href='pagar.php?id={$c['id']}' style='display:block;background:#2e7d32;color:white;padding:10px;text-align:center;border-radius:8px;text-decoration:none;font-weight:bold;margin-top:5px'>✅ PAGAR</a>";}?>
<?php if(!empty($c['archivo_traducido'])):?> <a href="<?= $c['archivo_traducido']?>" target="_blank" style="display:block;background:#0d6efd;color:white;padding:10px;text-align:center;border-radius:8px;text-decoration:none;font-weight:bold;margin-top:5px">📥 DESCARGAR TRADUCCIÓN</a> <?php endif;?>
<?php if(in_array($estado,['pendiente','cotizada','cotizado','aceptada',''])):?>
<a href="eliminar_cotizacion.php?id=<?= $c['id']?>" onclick="return confirm('¿Eliminar cotización #<?= $c['id']?>?')" style="display:block;background:#d32f2f;color:white;padding:10px;text-align:center;border-radius:8px;text-decoration:none;font-weight:bold;margin-top:8px">🗑️ Eliminar</a>
<?php endif;?>
</div>
<?php endwhile;?>
</div>