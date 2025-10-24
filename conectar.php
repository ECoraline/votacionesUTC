<?php
$conexion = mysqli_connect("localhost", "u356672979_Mango", "Animalitos12#", "u356672979_diamorido");

if (!$conexion) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
?>