<?php
session_start();
$conexion = new mysqli("localhost", "root", "", "login");
$correo = $_POST['mail'];

if (empty($correo)) {
    die("Correo vacío.");
}

$consulta = $conexion->prepare("SELECT ha_votado FROM invitados WHERE correo_invitado = ?");
$consulta->bind_param("s", $correo);
$consulta->execute();
$consulta->store_result();

$_SESSION['correo_invitado'] = $correo;

if ($consulta->num_rows > 0) {
    header("Location: Votaciones/votaciones.html");
    exit;
} else {
    $insertar = $conexion->prepare("INSERT INTO invitados (correo_invitado, ha_votado) VALUES (?, 0)");
    $insertar->bind_param("s", $correo);
    $insertar->execute();
    header("Location: Votaciones/votaciones.html");
    exit;
}
?>