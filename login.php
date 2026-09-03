<?php
session_start();
require_once ('config/conexion.php');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios_sistemas WHERE correo = '$usuario' AND PASSWORD= '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $datos = $result->fetch_assoc();
        $_SESSION['usuario'] = $datos['correo'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['rol'] = $datos['ROL'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location='index.php';</script>";
    }
}
?>
