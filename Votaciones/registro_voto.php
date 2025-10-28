<?php
$conexion = new mysqli("localhost", "root", "", "login");

$id = $_POST['id'];


$verificar = $conexion->query("SELECT * FROM concursantes WHERE idConcursante = '$id'");
if ($verificar->num_rows === 0) {
  echo "Concursante no encontrado.";
  exit;
}


$conexion->query("INSERT INTO votos (concursante_id) VALUES ('$id')");
echo "Voto registrado";
?>