<?php

$servername = "158.23.57.170";
$username = "guest";
$password = "UTCpass#02";
$dbname = "login";



$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
// si se quiere cambiar a otra base de datos, se tiene que crear la database y poner los mismos atributos que la anterior

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = $_POST['nombre1'] ?? '';
    $Apellido = $_POST['apellido1'] ?? '';
    $Numero = $_POST['telefono1'] ?? '';
    $Grupo = $_POST['grupo1'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $apellido2 = $_POST['apellido2'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $academia = $_POST['academia'] ?? '';
    $nombre_disfraz = $_POST['nombre_disfraz'] ?? '';
    $fotografia = $_POST['fotografia'] ?? '';
// Insertar datos en la tabla concursantes
    $sql = "INSERT INTO concursantes (nombre, apellidoM, numero, grupo, descripcion, apellidoP, correo, academia, nombreDisfraz, fotografia) VALUES ('$Nombre', '$Apellido', '$Numero', '$Grupo', '$descripcion', '$apellido2', '$correo', '$academia', '$nombre_disfraz', '$fotografia')";

    if ($conn->query($sql) === TRUE) {
        
        header("Location: registro.html");
        exit(); 
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}

$conn->close();
?>