<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebauni";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre1 = $_POST['nombre1'] ?? '';
    $contrasena1 = $_POST['contrasena1'] ?? '';

    
    $sql = "INSERT INTO usuarios (nombre, contrasena) VALUES ('$nombre1', '$contrasena1')";

    if ($conn->query($sql) === TRUE) {
        
        header("Location: index2.html");
        exit(); 
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}

$conn->close();
?>