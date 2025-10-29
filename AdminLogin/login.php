<?php
$servername = "158.23.57.170";
$username = "guest";
$password = "UTCpass#02";
$dbname = "login";


// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"]);
    $contrasena = trim($_POST["contrasena"]);

    
    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND contrasena = '$contrasena'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        echo "Inicio de sesión exitoso.";
        header("Location: /votacionesUTC/AdminPanel/Panel.html");
    exit;

    } else {
        echo "Usuario o contraseña incorrectos.";
    }
}

$conn->close();
?>