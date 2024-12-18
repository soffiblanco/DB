<?php
require 'vendor/autoload.php';
use RdKafka\Producer;

$conf = new RdKafka\Conf();
$conf->set('metadata.broker.list', 'localhost:9092');

$producer = new Producer($conf);
$topic = $producer->newTopic('transacciones');

$mensaje = ['test' => 'Kafka funcionando', 'fecha' => date('Y-m-d H:i:s')];
$topic->produce(RD_KAFKA_PARTITION_UA, 0, json_encode($mensaje));
$producer->flush(1000);

echo "Mensaje enviado a Kafka: " . json_encode($mensaje);
?>