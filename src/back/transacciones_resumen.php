<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;

$sql = "
SELECT 
    tt.Nombre AS TipoTransaccion, 
    COUNT(t.ID_Transaccion) AS TotalTransacciones,
    SUM(t.Monto) AS MontoTotal
FROM 
    transacciones t
JOIN 
    tipo_transaccion tt ON t.ID_TipoTransaccion = tt.ID_TipoTransaccion
GROUP BY 
    tt.Nombre;
";

$result = $conn->query($sql);
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>
