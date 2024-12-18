<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Consultar transacciones por cuenta
    $cuenta_id = $_GET['cuenta_id'] ?? null;

    if (!$cuenta_id) {
        http_response_code(400);
        echo json_encode(['error' => 'Cuenta ID requerida']);
        exit;
    }

    $stmt = $conexion->prepare("SELECT * FROM Transacciones WHERE cuenta_id = ?");
    $stmt->bind_param('i', $cuenta_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $transacciones = [];
    while ($row = $result->fetch_assoc()) {
        $transacciones[] = $row;
    }

    echo json_encode($transacciones);
    $stmt->close();
}
?>