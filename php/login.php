<?php
// 🔐 PASO 1: Iniciar la sesión
session_start();

// PASO 2: Verificar que los datos se envíen por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // PASO 3: Incluir la conexión a la base de datos
    require_once 'conexion.php';

    // PASO 4: Obtener los datos del formulario (esto estaba bien)
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // PASO 5: Preparar la consulta SQL con los nombres de tu tabla y columnas (esto estaba bien)
        $sql = "SELECT id_admin, usuario, contraseña FROM administrador WHERE usuario = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);

        // Obtenemos la fila del administrador (si existe)
        $admin = $stmt->fetch();

        // PASO 6: Verificar el administrador y la contraseña
        if ($admin && password_verify($password, $admin['contraseña'])) {
            
            // ¡ÉXITO! Credenciales correctas.
            
            // ✅ CORRECCIÓN: Usamos los nombres de columna correctos de tu base de datos.
            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['admin_usuario'] = $admin['usuario'];

            // Redirigimos al panel de administrador
            header("Location: ../AdminPanel/Panel.php");
            exit();

        } else {
            // ERROR: Usuario o contraseña incorrectos.
            header("Location: ../login.html?error=credenciales_invalidas");
            exit();
        }

    } catch (PDOException $e) {
        // Si hay un error con la base de datos, redirigimos con un error.
        header("Location: ../login.html?error=db_error");
        exit();
    }
} else {
    // Si alguien intenta acceder a este archivo directamente, lo mandamos al login.
    header("Location: ../login.html");
    exit();
}
?>