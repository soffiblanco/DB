<?php

$host = "127.0.0.1"; // Cambiado "localhost" por "127.0.0.1" para evitar problemas de sockets
$user = "root"; // Usuario de MySQL (por defecto en XAMPP)
$password = ""; // Contraseña de MySQL (vacía por defecto en XAMPP)
$dbname = "banco_linea"; // Nombre correcto de la base de datos

// Crear conexión
$conexion = new mysqli($host, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa";
}

?>