<?php
if(session_status()==PHP_SESSION_NONE) session_start();
include("config/conexion.php");
$uid = intval($_SESSION['id']?? $_SESSION['usuario_id']?? 0);
if($uid==0){ echo "No hay sesión"; exit; }

$res = $conn->query("SELECT * FROM cotizaciones WHERE usuario_id=$uid ORDER BY id DESC");
?>
<div style="font-family:Arial;max-width:700px;margin:auto">
<?php while($c=$res->fetch_assoc()):
 $estado = strtolower(trim($c['estado']));
?>
<div style="background:white;border-radius:12px;padding:15px;margin-bottom:15px;box-shadow:0 2px 5px #ccc;border:1px solid #ddd">

<b>ID #<?= $c['id']?> - <?= $c['fecha']?></b><br>
<b>Pediste:</b> <?= htmlspecialchars($c['observaciones'])?><br><br>

<!-- ARCHIVO - ESTO ES LO QUE TE FALTA -->
<div style="background:#f0f4ff;padding:12px;border-radius:8px;border-left:5px solid #1565c0">
<b>📄 Tu archivo:</b><br><br>
<?php
$arch = $c['archivos'] ?? '';
$mostrado = false;

if(!empty($arch) && $arch != '[]'){
    $lista = json_decode($arch, true);
    if(json_last_error()===JSON_ERROR_NONE && is_array($lista)){
        foreach($lista as $a){
            $a = trim($a);
            if($a=='') continue;
            // prueba 2 rutas: como está y con ../
            $ruta_ok = $a;
            if(!file_exists($a) && file_exists("../".$a)) $ruta_ok = "../".$a;
            
            echo "<a href='$ruta_ok' target='_blank' style='background:#1565c0;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;display:inline-block;font-weight:bold'>📄 Ver / Descargar Archivo</a><br>";
            echo "<small style='color:gray'>$a</small><br><br>";
            $mostrado = true;
        }
    }
}
        // --- BOTON PAGAR SI YA ESTA COTIZADA ---
        $estado = strtolower(trim($c['estado']?? ''));
        if($estado == 'cotizada'){
            $partes = explode("|", $c['detalles']?? '');
            $concepto = $partes[0]?? 'Traducción';
            $valor = $partes[1]?? '';
            $entrega = $partes[2]?? '';
            $incluye = $partes[3]?? '';

            echo "<div style='background:#e8f5e9;padding:15px;border-radius:10px;margin-top:15px;border-left:5px solid #2e7d32'>";
            echo "<b>✅ Respuesta del Admin</b><br>";
            echo "Concepto: ".htmlspecialchars($concepto)."<br>";
            echo "<b style='color:#2e7d32;font-size:20px'>Valor: ".htmlspecialchars($valor)."</b><br>";
            echo "Entrega: ".htmlspecialchars($entrega)."<br>";
            echo "Incluye: ".htmlspecialchars($incluye)."<br><br>";
            echo "<a href='pagar.php?id={$c['id']}' style='display:block;background:#2e7d32;color:white;padding:15px;text-align:center;border-radius:8px;text-decoration:none;font-weight:bold;font-size:16px'>✅ ACEPTAR Y PAGAR $valor</a>";
            echo "</div>";
        }

// FALLBACK: si tu BD vieja está vacía pero la carpeta si existe
$carpeta_vieja = "uploads/cotizacion_".$c['id']."/";
$carpeta_vieja2 = "../uploads/cotizacion_".$c['id']."/";
$carpeta_check = is_dir($carpeta_vieja) ? $carpeta_vieja : $carpeta_vieja2;

if(!$mostrado && is_dir($carpeta_check)){
    $archivos_en_carpeta = glob($carpeta_check."*");
    if(!empty($archivos_en_carpeta)){
        foreach($archivos_en_carpeta as $f){
            echo "<a href='$f' target='_blank' style='background:#2e7d32;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;display:inline-block;font-weight:bold'>📄 Ver Archivo en Carpeta</a><br>";
            echo "<small style='color:gray'>$f</small><br><br>";
            $mostrado = true;
        }
    }
}

if(!$mostrado){
    echo "<span style='background:red;color:white;padding:6px 10px;border-radius:6px'>❌ Esta cotización se guardó sin archivo. BD dice: ".htmlspecialchars($arch)."</span><br>";
    echo "<small>Carpeta buscada: $carpeta_check</small>";
}
?>

<?php if(!empty($c['archivo_traducido'])):?>
<hr>
<a href="<?= $c['archivo_traducido']?>" target="_blank" style="background:#2e7d32;color:white;padding:10px 15px;border-radius:8px;text-decoration:none;display:inline-block">📥 Descargar Traducción Final</a>
<?php endif;?>
</div>

<br>
<b>Estado:</b> <span style="background:<?= $estado=='pendiente'?'#ff9800':'#1e8c5a'?>;color:white;padding:5px 12px;border-radius:5px"><?= strtoupper($estado)?></span>

<?php if(!empty($c['detalles'])):?>
<div style="background:#e8f5e9;padding:10px;border-radius:8px;margin-top:10px">
<?= htmlspecialchars($c['detalles'])?>
</div>
<?php else:?>
<p style="color:gray"><i>Aún pendiente de cotización...</i></p>
<?php endif;?>

</div>
<?php endwhile;?>
</div>