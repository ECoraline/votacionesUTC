<?php
session_start();
include('conectar.php');

$accion = $_POST['accion'] ?? '';
$Nombre = $_POST['Nombre'] ?? '';
$contraseña = $_POST['contraseña'] ?? '';

if ($accion == "login") {
    //Consulta SQL para verificar si existen los datos
    $consulta = "SELECT * FROM jefecarrera WHERE Usuario = '$Nombre' AND contraseña = '$contraseña'";
    $resultado = mysqli_query($conexion, $consulta);

    // Validamos si se encontró el usuario
    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['nombre'] = $Nombre;
        $_SESSION['id_usuario'] = $usuario['id'];
        $_SESSION['login_time'] = time();
        
        header("Location: registro.php");
        exit();
    } else {
        echo "<script>
                alert('Usuario o contraseña incorrectos.');
                window.location.href = 'login.html';
              </script>";
        exit();
    }
    
    mysqli_close($conexion); 
}
?>