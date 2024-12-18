🚀 Proyecto: Simulador de Banca en Línea con Kafka

Este proyecto es un simulador de banca en línea que permite realizar transferencias entre cuentas, registrar transacciones y enviar mensajes a un broker Kafka para procesar eventos en tiempo real.

📋 Requisitos Previos

Antes de ejecutar el proyecto, asegúrate de tener instaladas las siguientes herramientas:
	1.	PHP 8+ y Composer
	2.	XAMPP (para servidor MySQL y Apache)
	3.	Kafka y Zookeeper
	•	Instalación con Homebrew:
    brew install kafka
    pecl install rdkafka
    

📂 Estructura del Proyecto

    banco_linea/
│
├── src/
│   ├── back/                      # Código Backend (APIs y conexión Kafka)
│   │   ├── conexion.php           # Conexión a MySQL
│   │   ├── transferencia.php      # API para procesar transferencias
│   │   ├── kafka_test.php         # Script de prueba para Kafka
│   │   ├── transacciones.php      # API para consultar transacciones
│   │   └── cuentas.php            # API para consultar cuentas
│   └── public/                    # Archivos Frontend
│
├── README.md                      # Documentación del proyecto
├── composer.json                  # Configuración de dependencias (rdkafka)
└── .gitignore                     # Archivos a ignorar en Git


⚙️ Configuración del Proyecto

1. Clona el Proyecto

git clone https://github.com/tu_usuario/banco_linea.git
cd banco_linea

2. Configura el Servidor Local

Inicia el servidor PHP en el directorio back:
php -S localhost:8000 -t src/back


3. Configura la Base de Datos MySQL
	1.	Abre phpMyAdmin (XAMPP).
	2.	Crea una base de datos llamada banca_linea.
	3.	Importa el archivo SQL para crear las tablas y procedimientos.

    mysql -u root -p banca_linea < banco_linea.sql


4. Instala Dependencias con Composer

Ejecuta el siguiente comando para instalar la librería de Kafka:
composer require rdkafka/rdkafka


5. Inicia Kafka y Zookeeper

En terminales separadas:

Zookeeper:
zookeeper-server-start /opt/homebrew/etc/kafka/zookeeper.properties

Kafka Broker:
kafka-server-start /opt/homebrew/etc/kafka/server.properties

Crea el tema de Kafka:
kafka-topics --create --topic transacciones --bootstrap-server localhost:9092 --partitions 1 --replication-factor 1

🚀 Prueba del API

1. Endpoint de Transferencias
	•	Método: POST
	•	URL:

http://localhost:8000/transferencia.php


2. Verifica los Mensajes en Kafka

Abre un consumidor Kafka para el tema transacciones:


kafka-console-consumer --topic transacciones --bootstrap-server localhost:9092 --from-beginning

🎉 ¡Listo!

Ahora tu API de banca en línea con Kafka está completamente funcional. Prueba los endpoints con Postman o cURL, verifica los mensajes en Kafka y asegúrate de que todo funcione correctamente.