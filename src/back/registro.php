<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, OPTIONS");

// Manejar preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';

// Leer el cuerpo JSON
$input = json_decode(file_get_contents("php://input"), true);

$nombre = $input['nombre'] ?? '';
$apellido = $input['Apellido'] ?? '';
$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (empty($nombre) || empty($apellido) || empty($email) || empty($password)) {
    echo json_encode(["status" => "error", "message" => "Todos los campos son obligatorios."]);
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Usuarios (nombre, Apellido, email, password) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $password_hash);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Usuario registrado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error al registrar: " . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error en la consulta: " . $conexion->error]);
}

$conexion->close();
?>