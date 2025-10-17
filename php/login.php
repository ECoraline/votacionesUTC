<?php
// Inicia la sesión para poder guardar variables de sesión
session_start();

// Verifica que los datos hayan sido enviados por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Incluye el archivo de conexión a la base de datos
    require_once 'conexion.php';

    // Recupera el email y la contraseña del formulario
    $email = $_POST['email']; // Asegúrate que el 'name' en tu HTML sea 'email'
    $password = $_POST['password']; // Asegúrate que el 'name' en tu HTML sea 'password'

    try {
        // Prepara la consulta SQL para buscar al usuario por su email
        // Usamos consultas preparadas para evitar inyección SQL
        $sql = "SELECT id, email, password FROM usuarios WHERE email = ?";
        $stmt = $pdo->prepare($sql);

        // Ejecuta la consulta pasando el email como parámetro
        $stmt->execute([$email]);

        // Obtiene el resultado de la consulta
        $user = $stmt->fetch();

        // Verifica si se encontró un usuario y si la contraseña coincide
        // usamos password_verify() para comparar la contraseña enviada con el hash guardado
        if ($user && password_verify($password, $user['password'])) {
            
            // ¡Credenciales correctas!
            // Guardamos información del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            // Redirigimos al usuario a una página de bienvenida o al panel de control
            header("Location: ../dashboard.php"); // Redirige a una página segura
            exit(); // Es importante terminar el script después de una redirección

        } else {
            // Credenciales incorrectas
            // Redirigimos de vuelta al login con un mensaje de error
            header("Location: ../login.html?error=1");
            exit();
        }

    } catch (PDOException $e) {
        // Manejo de errores de la base de datos
        die("Error en la consulta: " . $e->getMessage());
    }
} else {
    // Si alguien intenta acceder al script directamente sin enviar datos, lo redirigimos
    header("Location: ../login.html");
    exit();
}
?>