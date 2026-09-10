<?php
session_start();
require_once ('config/conexion.php');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // USAMOS SENTENCIA PREPARADA PARA EVITAR INYECCIÓN SQL
    //TU CAMPO SE LLAMA PASSWORD, NO CONTRASENA, ASÍ QUE LO CAMBIÉ EN LA CONSULTA

    $sql = "SELECT * FROM usuarios_sistemas WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $datos = $result->fetch_assoc();
     
 //tu campo PASSWORD PUEDE SER ENCRIPTADO

 $clave_db =$datos['PASSWORD']; // Asegúrate de que este campo coincida con el nombre en tu base de datos
$valido =false;
if (password_verify($contrasena, $clave_db)) {
        $valido = true; // Si esta escriptado con password_hash, es la forma recomendada
        }elseif($contrasena === $clave_db){
            $valido = true; //si esta en texto plano, aunque no es recomendable

        }      
            if($valido) {
            //  Guardamos los datos del usuario en la sesión

         $_SESSION['id'] = $datos['id']; //importante si tum id se llama id usuario cambilom aqui
        $_SESSION['usuario'] = $datos['correo'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['rol'] = strtolower($datos['ROL']); // que esa admin o cliente
       
        header("Location: dashboard.php");
        exit();
    } 
        echo "<script>alert('Usuario o contraseña incorrectos.'); window.location='index.php';</script>";
    }
    
}
$conn->close();
?>
