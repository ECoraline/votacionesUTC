<?php
// Verificamos que el formulario se haya enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Incluimos nuestro archivo de conexión a la BD
    require_once 'conexion.php';

    // --- 1. RECUPERAR DATOS DEL FORMULARIO ---
    // Asegúrate de que los 'name' en tu HTML coincidan con los de aquí
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_p'];
    $apellido_materno = $_POST['apellido_m']; // Asegúrate que el name en HTML sea 'apellido_m'
    $correo_institucional = $_POST['correo']; // Asegúrate que el name en HTML sea 'correo'
    $matricula = $_POST['matricula'];
    $nombre_disfraz = $_POST['nombre_disfraz'];
    $descripcion_disfraz = $_POST['descripcion']; // Asegúrate que el name en HTML sea 'descripcion'
    $telefono = $_POST['telefono'];
    $academia = $_POST['academia'];
    $grupo = $_POST['grupo'];
    $categoria = $_POST['categoria']; // Necesitarás añadir este campo a tu HTML

    // --- 2. MANEJAR LA SUBIDA DE LA IMAGEN ---
    
    // Verificamos si se subió un archivo y no hay errores
    if (isset($_FILES["foto_disfraz"]) && $_FILES["foto_disfraz"]["error"] == 0) {
        
        $directorio_subidas = '../uploads/';
        
        // Creamos un nombre único para el archivo para evitar que se reemplace
        $extension = strtolower(pathinfo($_FILES["foto_disfraz"]["name"], PATHINFO_EXTENSION));
        $nuevo_nombre_archivo = uniqid('disfraz_', true) . '.' . $extension;
        $ruta_destino = $directorio_subidas . $nuevo_nombre_archivo;
        
        // Movemos el archivo del directorio temporal al directorio de destino
        if (move_uploaded_file($_FILES["foto_disfraz"]["tmp_name"], $ruta_destino)) {
            
            // --- 3. GUARDAR TODO EN LA BASE DE DATOS ---
            try {
                // Preparamos la consulta SQL con los nuevos nombres de columna
                $sql = "INSERT INTO concursante 
                        (nombre, apellido_paterno, apellido_materno, correo_institucional, matricula, nombre_disfraz, descripcion_disfraz, telefono, academia, grupo, ruta_foto, categoria) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
                $stmt = $pdo->prepare($sql);

                // La ruta que guardamos en la BD es relativa al proyecto
                $ruta_db = 'uploads/' . $nuevo_nombre_archivo;
                
                // Ejecutamos la consulta con los datos en el orden correcto
                $stmt->execute([
                    $nombre, $apellido_paterno, $apellido_materno, $correo_institucional, $matricula, 
                    $nombre_disfraz, $descripcion_disfraz, $telefono, $academia, $grupo, 
                    $ruta_db, $categoria
                ]);

                // Redirigimos a una página de éxito
                header("Location: ../registro_exitoso.html");
                exit();

            } catch (PDOException $e) {
                die("Error al guardar en la base de datos: " . $e->getMessage());
            }

        } else {
            die("Error: Hubo un problema al subir tu archivo.");
        }
    } else {
        die("Error: No se subió ningún archivo o hubo un error en la subida.");
    }
} else {
    // Si no se envía por POST, redirigir o mostrar error
    header("Location: ../formulario_registro.html");
    exit();
}
?>