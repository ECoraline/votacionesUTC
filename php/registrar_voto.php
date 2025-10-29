<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST"); // Solo permitir peticiones POST

require_once 'conexion.php'; 

// 1. Leer los datos que nos envía el JavaScript
// file_get_contents("php://input") es la forma correcta de leer un cuerpo de petición JSON
$data = json_decode(file_get_contents("php://input"));

// 2. Validar que recibimos el ID del concursante
// Si no existe el id o no es un número, enviamos un error.
if (!isset($data->concursante_id) || !is_numeric($data->concursante_id)) {
    http_response_code(400); // 400 Bad Request
    echo json_encode(["error" => "ID de concursante inválido o no proporcionado."]);
    exit(); // Detenemos la ejecución
}

$concursante_id = $data->concursante_id;

// 3. Preparar y ejecutar la inserción en la base de datos
try {
    $sql = "INSERT INTO votos (concursante_id) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    
    // Ejecutamos la consulta pasando el ID
    $stmt->execute([$concursante_id]);

    // Si todo fue bien, enviamos una respuesta de éxito
    http_response_code(201); // 201 Created
    echo json_encode(["mensaje" => "Voto registrado exitosamente."]);

} catch (PDOException $e) {
    // Si algo falla en la base de datos (ej: el concursante no existe),
    // enviamos un error de servidor.
    http_response_code(500); // 500 Internal Server Error
    echo json_encode(["error" => "Error al registrar el voto: " . $e->getMessage()]);
}
?>