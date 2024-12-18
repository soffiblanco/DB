<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una cuenta
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario_id = $data['usuario_id'] ?? null;
    $tipo_cuenta = $data['tipo_cuenta'] ?? null;

    if (!$usuario_id || !$tipo_cuenta) {
        http_response_code(400);
        echo json_encode(['error' => 'Usuario ID y tipo de cuenta son requeridos']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO Cuentas (usuario_id, tipo_cuenta) VALUES (?, ?)");
    $stmt->bind_param('is', $usuario_id, $tipo_cuenta);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(['message' => 'Cuenta creada exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al crear cuenta']);
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener una cuenta por ID
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido']);
        exit;
    }

    $stmt = $conexion->prepare("SELECT * FROM Cuentas WHERE cuenta_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Cuenta no encontrada']);
    }
    $stmt->close();
}
?>