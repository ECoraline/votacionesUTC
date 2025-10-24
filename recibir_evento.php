<?php
// recibir_evento.php
session_start();
include('../conectar.php');


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['guardar']) && $_POST['guardar'] === 'subir') {
    // Sanitizar entradas de texto
    $titulo = htmlspecialchars(trim($_POST['titulo'] ?? ''));
    //variable = evita que agregen palabras reservadas de html(elimina espacio en blanco(lee el campo llamado x no mandes error si el campo esta vacio))
    $materiales = htmlspecialchars(trim($_POST['materiales'] ?? ''));
    $horario = htmlspecialchars(trim($_POST['horario'] ?? ''));
    if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $horario)) {
    echo "Formato correcto: $horario";
} else {
    echo "Formato incorrecto, debe ser YYYY-MM-DD HH:MM:SS";
}
    $lugar = htmlspecialchars(trim($_POST['lugar'] ?? ''));
    $descripcion = htmlspecialchars(trim($_POST['descripcion'] ?? ''));

    $imagenBase64 = "";

    // Verificar si se subió imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['imagen']['tmp_name'];
        $tipo = mime_content_type($tmpName); // ejemplo: image/png
        $datos = file_get_contents($tmpName);

        // Convertir a base64
        $imagenBase64 = 'data:' . $tipo . ';base64,' . base64_encode($datos);
       
    }
    /*// Mostrar resultados
    echo "<h2>Datos recibidos</h2>";
    echo "<p><b>Título:</b> $titulo</p>";
    echo "<p><b>Materiales:</b> $materiales</p>";
    echo "<p><b>Horario:</b> $horario</p>";
    echo "<p><b>Lugar:</b> $lugar</p>";
    echo "<p><b>Descripción:</b> $descripcion</p>";
*/
    if ($imagenBase64) {
        $AntiArias= $conexion->prepare("INSERT INTO materiagrafico (ruta_imagen) VALUES (?)");
        $AntiArias->bind_param("s", $imagenBase64 );
        if ($AntiArias->execute()) {
            echo "Imagen insertada correctamente.<br>";
        } else {
            echo "Error al insertar imagen: " . $stmt->error . "<br>";
        }
        $AntiArias->close();
        //verificar si se convirtio
        echo "<p><b>Imagen convertida a Base64:</b></p>";
        echo "<textarea cols='80' rows='8'>" . htmlspecialchars($imagenBase64) . "</textarea><br>";
        echo "<p><b>Vista previa:</b></p>";
        echo "<img src='$imagenBase64' width='200'> <br>";
    } else {
        echo "<p><b>No se subió imagen o hubo un error.</b></p>";
    }
    $vacuna=$conexion->prepare( "INSERT INTO actividad 
    (NombreActividad, requisitos, Fecha_Hora, lugar, descripcion)
    VALUES (?, ?, ?, ?, ?)");
    $vacuna->bind_param("sssss", $titulo, $materiales, $horario, $lugar, $descripcion);
    if($vacuna->execute()){ echo "actividad correcta.<br>";}else{
        echo "error al insertar actividad". $vacuna -> error . "<br>";
    }
    $vacuna->close();
} else {
    echo "Acceso no permitido.";
}
?>

