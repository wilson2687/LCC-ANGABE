<?php
ob_start();
session_start();
require_once('config/conexion.php');

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);

    $sql = "SELECT * FROM usuarios_sistemas WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verificamos las 2 formas de contraseña (encriptada o texto plano)
        if (password_verify($contrasena, $row['PASSWORD']) || $contrasena === $row['PASSWORD']) {
            $_SESSION['id_usuario'] = $row['id'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['usuario'] = $row['correo'];
            $_SESSION['nombre'] = $row['nombre'];

            $_SESSION['rol'] = strtolower($row['ROL']);
            $_SESSION['ROL'] = strtolower($row['ROL']);
            
           header("Location: dashboard.php");
exit();
        } else {
            $error = "Contraseña incorrecta,  La que pusiste no coincide.";
        }
    } else {
        $error = "Ese correo no está registrado: " . $usuario;
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>ANGABE</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial}
body{height:100vh;background:#111;display:flex;justify-content:center;align-items:center}
.modal{background:#d9d9d9;width:380px;padding:30px;border-radius:10px;position:relative}
.modal h2{text-align:center;margin-bottom:20px;color:#2c3e50;letter-spacing:3px}
label{font-weight:bold;font-size:13px;display:block;margin:10px 0 5px;color:#2c3e50}
input{width:100%;padding:11px;background:#9aa3b8;border:none;border-radius:6px}
.btn{width:100%;padding:12px;background:#2d9d4a;color:white;border:none;border-radius:6px;font-weight:bold;margin-top:20px;cursor:pointer}
.error{background:#ffb3b3;color:#800;padding:10px;border-radius:5px;text-align:center;margin-bottom:10px;font-size:13px}
</style>
</head>
<body>
<div class="modal">
<h2>ANGABE</h2>
<?php if($error!=""){ echo "<div class='error'>$error</div>"; } ?>
<form method="POST">
<label>Usuario</label><input type="text" name="usuario" required>
<label>Contraseña</label><input type="password" name="contrasena" required>
<button class="btn">INICIAR SESION</button>
</form>
<p style="text-align:center;margin-top:15px"><a href="index.php" style="text-decoration:none;color:#2c3e50">Volver al inicio</a></p>
</div>
</body>
</html>