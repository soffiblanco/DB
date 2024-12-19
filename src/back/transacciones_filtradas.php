<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;

$tipoTransaccion = $_GET['tipo'] ?? '';

if ($tipoTransaccion) {
    $sql = "
    SELECT 
        t.ID_Transaccion, 
        t.Monto, 
        t.FechaTransaccion 
    FROM 
        transacciones t
    JOIN tipo_transaccion tt ON t.ID_TipoTransaccion = tt.ID_TipoTransaccion
    WHERE tt.Nombre = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tipoTransaccion);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode(["error" => "Falta el parámetro 'tipo'."]);
}

$conn->close();
?>
