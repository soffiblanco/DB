<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;

$sql = "UPDATE cuentas SET EstadoCuenta = 0 WHERE Saldo = 0";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Cuentas con saldo cero desactivadas."]);
} else {
    echo json_encode(["error" => $conn->error]);
}

$conn->close();
?>
