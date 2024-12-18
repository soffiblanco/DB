<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear un usuario
    $data = json_decode(file_get_contents('php://input'), true);
    $nombre = $data['nombre'] ?? null;
    $email = $data['email'] ?? null;

    if (!$nombre || !$email) {
        http_response_code(400);
        echo json_encode(['error' => 'Nombre y email son requeridos']);
        exit;
    }

    $stmt = $conexion->prepare("INSERT INTO Usuarios (nombre, email) VALUES (?, ?)");
    $stmt->bind_param('ss', $nombre, $email);

    if ($stmt->execute()) {
        http_response_code(201);
        echo json_encode(['message' => 'Usuario creado exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al crear usuario']);
    }
    $stmt->close();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener un usuario por ID
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido']);
        exit;
    }

    $stmt = $conexion->prepare("SELECT * FROM Usuarios WHERE usuario_id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Usuario no encontrado']);
    }
    $stmt->close();
}
?>