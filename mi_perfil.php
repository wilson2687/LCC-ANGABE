<?php
session_start();
require_once('config/conexion.php');

if(!isset($_SESSION['id'])){
    header("Location: ../index.php");
    exit();
}

$id = $_SESSION['id'];
$mensaje = "";

// --- ACTUALIZAR DATOS ---
if(isset($_POST['actualizar'])){
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    if(!empty($_POST['PASSWORD'])){
        $pass = $_POST['PASSWORD'];
        $sql = "UPDATE usuarios_sistemas SET nombre=?, apellido=?, correo=?, PASSWORD=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $pass, $id);
    } else {
        $sql = "UPDATE usuarios_sistemas SET nombre=?, apellido=?, correo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $apellido, $correo, $id);
    }

    if($stmt->execute()){
        $mensaje = "<div class='alert alert-success'>✅ Tus datos fueron actualizados correctamente</div>";
        $_SESSION['usuario'] = $correo;
        $_SESSION['nombre'] = $nombre;
    } else {
        $mensaje = "<div class='alert alert-danger'>❌ Error: ".$conn->error."</div>";
    }
    $stmt->close();
}

// Traemos mis datos actuales
$result = $conn->query("SELECT * FROM usuarios_sistemas WHERE id=$id");
$datos = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-image: url('imagenes/img-berlin.png');
        background-size: cover;
        background-position: center top;
        background-repeat: no-repeat;
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .card {
        background: rgba(255, 255, 255, 0.92);
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    }
    .badge-estado{padding:6px 12px; border-radius:20px; color:white; font-weight:bold; font-size:11px;}
    .pendiente{background:orange} .aceptada{background:#1e8c5a} .rechazada{background:#c0392b} .en_proceso{background:#0d6efd}
</style>
</head>
<body>
<div class="container mt-4" style="max-width:650px;">
    <h3 class="mb-1">Gestionar Mi Usuario</h3>
    <p>Rol: <b><?= strtoupper($_SESSION['rol']) ?></b> | Usuario: <b><?= $_SESSION['usuario'] ?></b></p>
    
    <a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">← Volver</a>
    
    <?= $mensaje ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h5>👤 Mis Datos</h5>
            <form method="POST">
                <div class="mb-2">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($datos['nombre']) ?>" required>
                </div>
                <div class="mb-2">
                    <label>Apellido</label>
                    <input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($datos['apellido']) ?>" required>
                </div>
                <div class="mb-2">
                    <label>Correo (usuario)</label>
                    <input type="email" name="correo" class="form-control" value="<?= htmlspecialchars($datos['correo']) ?>" required>
                </div>
                <div class="mb-3">
                    <label>Nueva Contraseña</label>
                    <input type="password" name="PASSWORD" class="form-control" placeholder="Dejar en blanco si no quieres cambiarla">
                </div>
                <button type="submit" name="actualizar" class="btn w-100 text-white" style="background-color: #1e8c5a;">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <!-- NUEVA SECCION: ESTADO DE MI SOLICITUD -->
    <div class="card shadow">
        <div class="card-body">
            <h5 style="color:#1e8c5a;">📦 Estado de mi Solicitud</h5>
            <p class="text-muted" style="font-size:13px;">Aquí ves el estado actual de tus cotizaciones enviadas.</p>
            
            <?php
            $sqlEstado = "SELECT * FROM cotizaciones WHERE usuario_id = '$id' ORDER BY id DESC";
            $resEstado = $conn->query($sqlEstado);
            if($resEstado && $resEstado->num_rows > 0){
                while($e = $resEstado->fetch_assoc()){
                    $est = $e['estado'] ?? 'pendiente';
                    echo "<div style='border-left:5px solid #1e8c5a; background:#f8f9fa; padding:10px 12px; margin:10px 0; border-radius:6px; display:flex; justify-content:space-between; align-items:center;'>";
                    echo "<div><b>#".$e['id']."</b> - ".htmlspecialchars(substr($e['observaciones'],0,45))."...<br><small style='color:gray;'>".($e['fecha'] ?? $e['created_at'] ?? '')."</small></div>";
                    echo "<span class='badge-estado $est'>".strtoupper(str_replace('_',' ',$est))."</span>";
                    echo "</div>";
                }
            } else {
                echo "<div class='alert alert-warning' style='font-size:14px;'>Aún no tienes cotizaciones. Ve a <b>Gestión de Cotizaciones</b> y envía una.</div>";
            }
            ?>
            <div class="mt-3 p-2" style="background:#e8f5e9; border-radius:6px; font-size:12px;">
                🟠 <b>PENDIENTE:</b> Recibida<br>
                🔵 <b>EN PROCESO:</b> La estamos revisando<br>
                🟢 <b>ACEPTADA:</b> ¡Aceptamos tu solicitud!<br>
                🔴 <b>RECHAZADA:</b> No fue posible
            </div>
        </div>
    </div>

</div>
</body>
</html>
<?php $conn->close(); ?>