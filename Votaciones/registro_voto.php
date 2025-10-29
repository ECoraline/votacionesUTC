<?php
session_start(); // Inicia la sesión para acceder al correo

$conn = new mysqli("158.23.57.170", "guest", "UTCpass#02", "login");

// Recuperar el correo desde la sesión
$correo = $_SESSION['correo_invitado'] ?? null;
$id_encuesta = $_POST['id_concursante'] ?? null;

// Verificar si el correo existe y si ya votó
$sql_check = "SELECT ha_votado FROM invitados WHERE correo_invitado = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $correo);
$stmt_check->execute();
$result = $stmt_check->get_result();

if ($result->num_rows === 0) {
    echo "Correo no registrado.";
} else {
    $row = $result->fetch_assoc();
    if ($row['ha_votado'] == 1) {
        echo "<script>
            alert('Ya has votado. Gracias por participar.');
            window.location.href = 'votaciones.html';
        </script>";
    } else {
        // Registrar el voto
        $sql_insert = "INSERT INTO votos_realizados (ip_usuario, id_concursante, fecha_voto) VALUES (?, ?, NOW())";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("si", $correo, $id_encuesta);
        $stmt_insert->execute();

        // Marcar que el usuario ya votó
        $sql_update = "UPDATE invitados SET ha_votado = 1 WHERE correo_invitado = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("s", $correo);
        $stmt_update->execute();

        echo "<script>
            alert('¡Voto registrado con éxito!');
            window.location.href = 'votaciones.html';
        </script>";
    }
}

// Cerrar conexiones si fueron creadas
if (isset($stmt_check)) $stmt_check->close();
if (isset($stmt_insert)) $stmt_insert->close();
if (isset($stmt_update)) $stmt_update->close();
$conn->close();
?>