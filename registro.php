<?php
session_start();
include('conectar.php');

$nombre = $_SESSION['nombre'] ?? '';

// Sam: aqui estoy agregando un if donde va a redirigir si no hay una sesion activa
if (empty($nombre)) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['accion']) && $_POST['accion'] === 'registrar') {

    $Nombre = htmlspecialchars(trim($_POST['Nombre']?? ''));
    $apellidop = htmlspecialchars(trim($_POST['apellidop']?? ''));
    $apellidom = htmlspecialchars(trim($_POST['apellidom']?? ''));
    $telefono = htmlspecialchars(trim($_POST['telefono']?? ''));
    $carrera = htmlspecialchars(trim($_POST['carrera']?? ''));
    $matricula = htmlspecialchars(trim($_POST['matricula']?? ''));
    $correo = htmlspecialchars(trim($_POST['correo']?? ''));
    $grupo = htmlspecialchars(trim($_POST['grupo']?? ''));
    $alias = htmlspecialchars(trim($_POST['alias']?? ''));

    // Obtener el último número de concursante
    $result = mysqli_query($conexion, "SELECT MAX(NConcursante) AS max_num FROM alumno");
    $row = mysqli_fetch_assoc($result);

    // Si no hay registros todavía, empieza en 1
    //$nconcursante = ($row['max_num'] ?? 0) + 1;
    $result = mysqli_query($conexion, "SELECT MAX(NConcursante) AS max_num FROM alumno");
    $row = mysqli_fetch_assoc($result);
    $nconcursante = ($row['max_num'] ?? 0) + 1;

    // Insertar datos en la tabla 'alumno'
    $AntiArias= $conexion->prepare("INSERT INTO alumno 
            (Alias, NConcursante, Nombre, ApellidoPaterno, ApellidoMaterno, Telefono, NombreAcademia, Matricula, Correo, Grupo)
            VALUES (?, ?, ?, ?, ?,  ?, ?, ?, ?, ?)");
           
            $AntiArias->bind_param("isssssssss", $alias, $nconcursante, $Nombre, $apellidop, $apellidom, $telefono, $carrera, $matricula, $correo, $grupo);
            
            if($AntiArias->execute()){ 
                echo "<script>
                    alert('🎉 Registro exitoso. Número de concursante: $nconcursante');
                    window.location.href = 'registro.php';
                    </script>";
                 exit;  
                
            }else{
        echo "error al registrar". $AntiArias-> error;
    }$AntiArias->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo.css">
    <link rel="stylesheet" href="registrov.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro</title>
</head>

<body>
    <header>
        <nav class = "navbar navbar-expand-lg navbar-dark">
          <div class = "container-fluid">
            <a  class = "logo2" href="eventos.html">
            <img src="Recursos/utc sin fondo.png" alt="logo" height="60">
            </a>
            <button class = "navbar-toggler ms-auto" type = "button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Menu">
              <span class = "navbar-toggler-icon"></span>
            </button>
    
            <div class = "collapse navbar-collapse" id = "navbarNav">
              <ul class = "navbar-nav ms-auto">
                <li class = "nav-item"> <a class = "nav-link" href="eventos.html">Eventos</a></li>
                <li class = "nav-item"> <a class = "nav-link" href="admin.html">Concurso</a></li>
                <li class="nav-item"><a class="nav-link" href="jefes.html">Crea evento</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
              </ul>
            </div>
          </div>
        </nav>
    </header>
    <div class="titulo">
        <h2>¡Bienvenido! <br>Registra Concursantes</h2>
    </div>
    <form action="" method="post">
        <main class="registro">
            <div class="seccion"> 
                <div class="fila"> 
                    <label for="Nombre">Nombre:</label>
                    <input type="text" id="Nombre" name="Nombre"/>
                </div>
                <div class="fila"> 
                    <label for="apellidop">Apellido Paterno:</label>
                    <input type="text" id="AP" name="apellidop"/>
                </div>
                <div class="fila"> 
                    <label for="apellidom">Apellido Materno:</label>
                    <input type="text" id="AM" name="apellidom"/>
                </div>
                <div class="fila"> 
                    <label for="telefono">Telefono:</label>
                    <input type="text" id="cell" name="telefono"/> 
                </div>
            </div>
            <div class="seccion">
                <div class="fila"> 
                    <label for="carrera">Carrera:</label>
                    <input type="text" id="carrera" name="carrera"/>
                </div>
                <div class="fila"> 
                    <label for="matricula">Matricula:</label>
                    <input type="text" id="matricula" name="matricula"/>
                </div>
                <div class="fila"> 
                    <label for="correo">Correo:</label>
                    <input type="email" id="email" name="correo"
                    pattern=".+@edu.utc.mx" size="30" required />
                </div>
                <div class="fila">
                    <label for="grupo">Grupo:</label>
                    <input type="text" id="grupo" name="grupo"/>
                    <label><input type="checkbox" id="cbox" value="checar" /> Confirma el pago antes de continuar</label>
                </div>
            </div>
        </main>
        <div class="boton"> 
            <button class= "btn" type="button" onclick= "window.history.back()" >Cancelar</button>
            <div class="apodo">
                <div class="fila"> 
                    <label for="alias">Nombre del dizfraz o Alias</label>
                    <input type="text" id="alias" name="alias"  disabled/>
                    <button class= "btn" type="submit" name="accion" value="registrar" id= "aceptar" disabled>Confirmar</button>
                </div>
            </div>
            <div style="text-align: center; margin-top: 50px; padding-bottom: 20px;">
    <a class="btn btn-danger btn-lg" href="logout.php">
        Cerrar Sesión
    </a>
</div>
        </div>
    </form>
    
<script>
  const checkbox = document.getElementById('cbox');
  const boton = document.getElementById('aceptar');
  const intput = document.getElementById('alias');
    checkbox.addEventListener('change', function() {
            boton.disabled = !this.checked;
            intput.disabled = !this.checked; // habilita o deshabilita el botón
        }
    );
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
</script>    

</body>
<footer>
    @2025 Derechos reservados
</footer>
</html>