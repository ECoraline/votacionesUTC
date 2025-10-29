<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'conexion.php'; 

try {
    $sql = "SELECT 
                id, 
                CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo, 
                nombre_disfraz, 
                descripcion_disfraz, 
                ruta_foto,
                categoria
            FROM concursante
            ORDER BY categoria";
    
    $stmt = $pdo->query($sql);
    $concursantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $concursantes_por_categoria = [];

    foreach ($concursantes as $concursante) {
        $categoria = $concursante['categoria'];
        if (!isset($concursantes_por_categoria[$categoria])) {
            $concursantes_por_categoria[$categoria] = [];
        }
        array_push($concursantes_por_categoria[$categoria], $concursante);
    }
    
    echo json_encode($concursantes_por_categoria);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al obtener los concursantes: " . $e->getMessage()]);
}
?>