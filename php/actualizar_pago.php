<?php
// Inicia la sesión y protege el script
session_start();
if (!isset($_SESSION['admin_id'])) {
    // Si no es un admin, se niega el acceso
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit();
}

// Verifica que se haya enviado un ID por POST
if (!isset($_POST['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID de concursante no proporcionado']);
    exit();
}

require_once 'conexion.php';

$id_concursante = $_POST['id'];

try {
    // 1. Obtenemos el estado actual del pago
    $stmt = $pdo->prepare("SELECT estatus_pago FROM concursante WHERE id = ?");
    $stmt->execute([$id_concursante]);
    $concursante = $stmt->fetch();

    if ($concursante) {
        // 2. Invertimos el estado (si es 1 lo vuelve 0, si es 0 lo vuelve 1)
        $nuevo_estatus = $concursante['estatus_pago'] == 1 ? 0 : 1;

        // 3. Actualizamos la base de datos con el nuevo estado
        $update_stmt = $pdo->prepare("UPDATE concursante SET estatus_pago = ? WHERE id = ?");
        $update_stmt->execute([$nuevo_estatus, $id_concursante]);

        // 4. Enviamos una respuesta exitosa al JavaScript
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'nuevo_estatus' => $nuevo_estatus]);
    } else {
        throw new Exception("Concursante no encontrado.");
    }

} catch (Exception $e) {
    // Si algo sale mal, enviamos un error
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>