<?php
session_start();
$_SESSION = array();
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="3;url=index.php">
    <title>Cerrando sesión - Angabe</title>
    <style>
        body {
            margin:0;
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background-image: url('imagenes/img-berlin.png');
            background-size: cover;
            background-position: center;
            font-family: 'Segoe UI', sans-serif;
            color: white;
        }
        .card {
            background: white;
            color: #0f172a;
            padding: 40px 50px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            animation: pop 0.5s ease;
        }
        @keyframes pop {
            from { transform: scale(0.8); opacity:0; }
            to { transform: scale(1); opacity:1; }
        }
        .check {
            font-size: 60px;
            margin-bottom: 10px;
        }
        .loader {
            margin: 20px auto;
            width: 40px;
            height: 40px;
            border: 4px solid #e2e8f0;
            border-top: 4px solid #0f172a;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        a { color: #0f172a; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <div class="check">👋</div>
        <h2>¡Sesión cerrada!</h2>
        <p>Gracias por usar Angabe.<br>Te estamos llevando al inicio...</p>
        <div class="loader"></div>
        <p style="font-size:13px; margin-top:15px;">Si no te redirige, <a href="index.php">haz clic aquí</a></p>
    </div>
</body>
</html>