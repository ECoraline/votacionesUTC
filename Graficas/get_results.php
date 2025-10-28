<?php
$conn = new mysqli("localhost", "root", "", "login");

$sql = "SELECT 
          CONCAT(C.nombre, ' ', C.apellidoP, ' ', C.apellidoM) AS nombreDisfraz,
          COUNT(V.id_concursante) AS total_votos
        FROM concursantes C
        LEFT JOIN votos_realizados V ON C.idConcursante = V.id_concursante
        GROUP BY C.idConcursante
        ORDER BY total_votos DESC";

$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>Nombre del Disfraz</th><th>Total de Votos</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['nombreDisfraz'] . "</td>";
    echo "<td>" . $row['total_votos'] . "</td>";
    echo "</tr>";

}

echo "</table>";

$conn->close();
?>