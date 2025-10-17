<?php
// Inicia la sesión y protege la página
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../Login.html');
    exit();
}

// Incluye la conexión a la base de datos
require_once '../php/conexion.php';

// --- 1. OBTENER TODOS LOS CONCURSANTES ---
$stmt = $pdo->query("SELECT * FROM concursante ORDER BY id ASC");
$concursantes = $stmt->fetchAll();

// --- 2. CALCULAR LAS ESTADÍSTICAS ---
$total_registrados = count($concursantes);
$total_pagados = 0;
$total_adeudo = 0;
$precio_entrada = 100; // Define aquí el costo de la entrada

foreach ($concursantes as $concursante) {
    if ($concursante['estatus_pago'] == 1) {
        $total_pagados++;
    } else {
        $total_adeudo++;
    }
}
$total_recaudado = $total_pagados * $precio_entrada;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-g" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="AdminPanel.css" />
</head>
<body>
    <div class="contenedor">
        <main class="contenidoPrincipal">
            <section class="tarjetas">
                <div class="tarjeta">
                    <h3>Alumnos Registrados</h3>
                    <p id="alumnosRegistrados"><?php echo $total_registrados; ?></p>
                </div>
                <div class="tarjeta">
                    <h3>Sin Adeudo</h3>
                    <p id="sinAdeudo"><?php echo $total_pagados; ?></p>
                </div>
                <div class="tarjeta">
                    <h3>Con Adeudo</h3>
                    <p id="conAdeudo"><?php echo $total_adeudo; ?></p>
                </div>
                <div class="tarjeta">
                    <h3>Total Recaudado</h3>
                    <p id="totalRecaudado">$<?php echo number_format($total_recaudado, 2); ?></p>
                </div>
            </section>

            <section class="seccionTabla">
                <h2>Lista Pagos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>ID</th>
                            <th>Matrícula</th>
                            <th>Fecha Registro</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($concursantes as $concursante): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($concursante['nombre'] . ' ' . $concursante['apellido_paterno']); ?></td>
                                <td>#<?php echo $concursante['id']; ?></td>
                                <td><?php echo htmlspecialchars($concursante['matricula']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($concursante['fecha_registro'])); ?></td>
                                <td>
                                    <?php if ($concursante['estatus_pago'] == 1): ?>
                                        <button class="estadoPago pagado" onclick="cambiarEstado(this, <?php echo $concursante['id']; ?>)">
                                            Pagado
                                        </button>
                                    <?php else: ?>
                                        <button class="estadoPago adeudo" onclick="cambiarEstado(this, <?php echo $concursante['id']; ?>)">
                                            Pendiente de Pago
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
            <a href="../php/logout.php" class="boton-logout">Cerrar Sesión</a>
        </main>
    </div>

    <script>
        async function cambiarEstado(button, id) {
            // Creamos un objeto para enviar el ID al servidor
            const formData = new FormData();
            formData.append('id', id);

            try {
                // Hacemos la petición al nuevo script PHP
                const response = await fetch('../php/actualizar_pago.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Si el servidor confirma el cambio, actualizamos el botón
                    if (result.nuevo_estatus == 1) {
                        button.textContent = 'Pagado';
                        button.classList.remove('adeudo');
                        button.classList.add('pagado');
                    } else {
                        button.textContent = 'Con Adeudo';
                        button.classList.remove('pagado');
                        button.classList.add('adeudo');
                    }
                    // Actualizamos las tarjetas de resumen
                    actualizarTarjetas();
                } else {
                    alert('Error al actualizar el estado: ' + result.message);
                }
            } catch (error) {
                console.error('Error de red:', error);
                alert('Hubo un problema de conexión. Inténtalo de nuevo.');
            }
        }
        
        // Función para actualizar los contadores en las tarjetas
        function actualizarTarjetas() {
            // Contamos cuántos botones tienen la clase 'pagado' o 'adeudo'
            const pagados = document.querySelectorAll('.estadoPago.pagado').length;
            const adeudos = document.querySelectorAll('.estadoPago.adeudo').length;
            const precioEntrada = <?php echo $precio_entrada; ?>;

            // Actualizamos el texto en el HTML
            document.getElementById('sinAdeudo').textContent = pagados;
            document.getElementById('conAdeudo').textContent = adeudos;
            document.getElementById('totalRecaudado').textContent = '$' + (pagados * precioEntrada).toFixed(2);
        }
    </script>
</body>
</html>