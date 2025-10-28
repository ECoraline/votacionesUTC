<?php
$conexion = new mysqli("localhost", "root", "", "login");

$resultado = $conexion->query("SELECT nombreDisfraz, descripcion, fotografia FROM concursantes");

$contestants = [];

while ($fila = $resultado->fetch_assoc()) {
    $contestants[] = [
        "name" => $fila['nombreDisfraz'],
        "description" => $fila['descripcion'],
        "image" => "uploads/" . $fila['fotografia']
    ];
}

header('Content-Type: application/json');
echo json_encode($contestants);
?>