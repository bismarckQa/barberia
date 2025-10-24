<?php
// TEST directo de citas
require_once 'models/Cita.php';

$citaModel = new Cita();
$citas = $citaModel->getProximas(5);

echo "<h1>TEST DE CITAS PRÓXIMAS</h1>";
echo "<p><strong>Total de citas obtenidas:</strong> " . count($citas) . "</p>";

if (empty($citas)) {
    echo "<p style='color:red;'>NO HAY CITAS</p>";
} else {
    echo "<h2>Citas encontradas:</h2>";
    echo "<ul>";
    foreach ($citas as $cita) {
        echo "<li>";
        echo "<strong>" . $cita['nombre_cliente'] . "</strong> - ";
        echo "Fecha: " . $cita['fecha_cita'] . " ";
        echo "Hora: " . $cita['hora_cita'] . " ";
        echo "Estado: " . $cita['estado'];
        echo "</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<h2>Query SQL usada:</h2>";
echo "<pre>";
echo "SELECT * FROM citas
WHERE estado = 'esperando' AND fecha_cita >= CURDATE()
ORDER BY fecha_cita ASC, hora_cita ASC
LIMIT 5";
echo "</pre>";
?>
