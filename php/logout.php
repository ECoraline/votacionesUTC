<?php
// Siempre se debe iniciar la sesión para poder manipularla.
session_start();

// 1. Elimina todas las variables de la sesión (ej. $_SESSION['admin_id']).
session_unset();

// 2. Destruye la sesión por completo en el servidor.
session_destroy();

// 3. Redirige al usuario a la página de login.
header('Location: ../AdminLogin/Login.html'); // Asegúrate que la ruta a tu login sea correcta.
exit();
?>