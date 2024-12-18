<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include 'conexion.php';

$query = "
    SELECT 
        u.usuario_id,
        u.nombre,
        u.Apellido,
        c.cuenta_id,
        c.tipo_cuenta,
        c.saldo
    FROM 
        Usuarios u
    LEFT JOIN 
        Cuentas c ON u.usuario_id = c.usuario_id
    ORDER BY 
        u.usuario_id, c.cuenta_id
";

$result = $conexion->query($query);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
?>