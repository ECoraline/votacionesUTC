<?php
$conn = new mysqli("localhost", "root", "", "login");

$sql = "SELECT c.nombreDisfraz, COUNT(v.id_concursante) AS total_votos
        FROM votos_realizados v
        JOIN concursantes c ON v.id_concursante = c.idConcursante
        GROUP BY c.nombreDisfraz
        ORDER BY total_votos DESC";

$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>Disfraz</th><th>Total de Votos</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['nombreDisfraz'] . "</td>";
    echo "<td>" . $row['total_votos'] . "</td>";
    echo "</tr>";
}

echo "</table>";

$conn->close();
?>