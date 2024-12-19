<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;

$sql = "
EXPLAIN SELECT 
    u.Nombre, 
    c.ID_Cuenta, 
    t.Monto
FROM 
    usuarios u
JOIN 
    cuentas c ON u.ID_Usuario = c.ID_Usuario
JOIN 
    transacciones t ON c.ID_Cuenta = t.ID_Cuenta;
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
