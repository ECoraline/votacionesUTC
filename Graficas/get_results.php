<?php
$conexion = new mysqli("localhost", "root", "", "login");

// Consulta para contar votos agrupados por concursante
$resultado = $conexion->query("
  SELECT idConcursante, COUNT(*) AS total_votos
  FROM votos
  GROUP BY idConcursante
");

$datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $consultaNombre = $conexion->prepare("SELECT nombreDisfraz FROM concursantes WHERE id = ?");
    $consultaNombre->bind_param("i", $fila['idConcursante']);
    $consultaNombre->execute();
    $consultaNombre->bind_result($nombre);
    $consultaNombre->fetch();
    $consultaNombre->close();

    $datos[] = [
        "nombre" => $nombre,
        "votos" => $fila['total_votos']
    ];
}

header('Content-Type: application/json');
echo json_encode($datos);
?>