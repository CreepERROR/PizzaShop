<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$message_queue = 'commandes';

try {
    $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
} catch (Exception $e) {
    echo "Impossible de se connecter au serveur RabbitMQ : \n";
    echo $e->getMessage();
    exit(1);
}

$channel = $connection->channel();
$msg = $channel->basic_get($message_queue);

if ($msg) {
    $content = json_decode($msg->body, true);
    print "[x] message reçu : \n" ;
    $channel->basic_ack($msg->getDeliveryTag());
    print "\n";
} else {
    print "[x] pas de message reçu\n"; exit(0);
}
$channel->close();
$connection->close();