<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;


$sql = "
SELECT 
    u.Nombre, 
    u.Apellido, 
    c.ID_Cuenta, 
    tc.Nombre AS TipoCuenta, 
    c.Saldo
FROM 
    usuarios u
JOIN 
    cuentas c ON u.ID_Usuario = c.ID_Usuario
JOIN 
    tipo_cuenta tc ON c.ID_TipoCuenta = tc.ID_TipoCuenta;
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
