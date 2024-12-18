<?php
// Incluir conexión a la base de datos
include 'conexion.php';

// Cargar autoload de Composer para Kafka y variables de entorno
require 'vendor/autoload.php';

use RdKafka\Producer;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Leer datos enviados en el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);
    $origen = $data['origen'] ?? null;
    $destino = $data['destino'] ?? null;
    $monto = $data['monto'] ?? null;

    // Validar datos requeridos
    if (!$origen || !$destino || !$monto || !is_numeric($monto) || $monto <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Origen, destino y monto son requeridos, y el monto debe ser positivo.']);
        exit;
    }

    // Iniciar transacción en la base de datos
    $conexion->begin_transaction();

    try {
        // Ejecutar procedimiento almacenado para transferencia
        $stmt = $conexion->prepare("CALL sp_transferir(?, ?, ?)");
        $stmt->bind_param('iid', $origen, $destino, $monto);

        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar el procedimiento almacenado.');
        }

        // Confirmar transacción en caso de éxito
        $conexion->commit();

        // Enviar mensaje a Kafka
        try {
            $conf = new RdKafka\Conf();
            $conf->set('metadata.broker.list', 'localhost:9092');

            $producer = new Producer($conf);
            $topic = $producer->newTopic('transacciones');

            $mensaje = [
                'origen' => $origen,
                'destino' => $destino,
                'monto' => $monto,
                'fecha' => date('Y-m-d H:i:s')
            ];

            $topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($mensaje));
            $producer->flush(1000);
        } catch (Exception $e) {
            // En caso de error en Kafka, no afecta la transferencia
            error_log('Error enviando mensaje a Kafka: ' . $e->getMessage());
        }

        // Respuesta de éxito
        http_response_code(200);
        echo json_encode([
            'message' => 'Transferencia procesada y mensaje enviado a Kafka.',
            'detalle' => $mensaje
        ]);
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conexion->rollback();
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    } finally {
        $stmt->close();
    }
}