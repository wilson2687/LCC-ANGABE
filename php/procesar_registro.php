<?php
require_once "../config/conexion.php";
$nombre=$_POST['nombre'];
$apellidos=$_POST['apellidos'];
$correo=$_POST['correo'];
$contrasena=$_POST['contrasena'];
$contrasena_hash=password_hash($contrasena,PASSWORD_DEFAULT);
$confirmar_contrasena=$_POST['confirmar_contrasena'];
$documento=$_POST['documento'];
$tipo_documento=$_POST['tipo_documento'];
$sql="INSERT INTO usuarios_sistemas(nombre,apellido,correo,PASSWORD)
VALUES('$nombre','$apellidos','$correo','$contrasena_hash')";

try {

    mysqli_query($conn, $sql);
    echo '
   <!DOCTYPE html>
    <html lang="es">
    <head>
    <metacharset="UTF-8">
    <title>REGISTRO EXITOSO</title>

    <style>
   body{
    background-image: url("../imagenes/img-berlin.png");
    background-size: cover;
    background-position: center top;
    background-repeat: no-repeat;
    margin: 0;
    font-family: Arial, sans-serif;
}
    .contenedor {
    width:420px;
    margin:80px auto;
    background:rgba(0,0,0,0.15);
    backdrop-filter:blur(6px);
    padding:30px;
    border-radius:12px;
    text-align:center;
    box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }
    h1{
    color:white;
    text-shadow:2px 2px 6px black;
}
    p{
    color:white;
    text-shadow:2px 2px 6px black;

a{
display:inline-block;
margin-top:20px;
background:#007bff;
color:white;
padding:12px 25px;
text-decoration:none;
border-radius:8px;
}
a:hover{
background:#0056b3;
}
</style>
</head>
<body>
<div class="contenedor">
<h1>REGISTRO EXITOSO</h1>
<p>EL USUARIO FUE REGISTRADO CORRECTAMENTE.</P>
<a href="../login.php">iniciar sesión></a>

</div>
</body>
</html>';

}
 catch (mysqli_sql_exception $e) {

    if ($e->getCode() == 1062) {
        echo "ESTE CORREO YA ESTA REGISTRADO.";
    } else {
        echo "Error: " . $e->getMessage();
    }

}