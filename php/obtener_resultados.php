<?php
header("Content-Type: application/json; charset=UTF-8");
require_once 'conexion.php'; 

try {
    // 1. LA CONSULTA SQL CLAVE
    // Esta consulta une las dos tablas, cuenta los votos de cada concursante
    // y se asegura de incluir a los que tienen 0 votos (gracias a LEFT JOIN).
    $sql = "SELECT 
                c.id, 
                c.nombre_disfraz,
                c.ruta_foto,
                c.categoria,
                COUNT(v.id) AS total_votos
            FROM 
                concursante c
            LEFT JOIN 
                votos v ON c.id = v.concursante_id
            GROUP BY 
                c.id
            ORDER BY 
                c.categoria, total_votos DESC";

    $stmt = $pdo->query($sql);
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Agrupamos los resultados por categoría, igual que antes
    $resultados_por_categoria = [];
    foreach ($resultados as $resultado) {
        $categoria = $resultado['categoria'];
        if (!isset($resultados_por_categoria[$categoria])) {
            $resultados_por_categoria[$categoria] = [];
        }
        array_push($resultados_por_categoria[$categoria], $resultado);
    }
    
    // 3. Devolvemos los resultados agrupados en formato JSON
    echo json_encode($resultados_por_categoria);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Error al obtener los resultados: " . $e->getMessage()]);
}
?>