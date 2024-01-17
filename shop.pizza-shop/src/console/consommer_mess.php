<?php
use PhpAmqpLib\Message\AMQPMessage;
use \PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__ . '/../../vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
try {
    $connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
} catch (Exception $e) {
    print "[x] Erreur de connexion : " . $e->getMessage() . "\n";
    //exit(1);
}
$channel = $connection->channel();
$msg = $channel->basic_get($message_queue);
if ($msg) {
    $content = json_decode($msg->body, true);
    print "[x] commande bien acquittée \n" ;
    $channel->basic_ack($msg->getDeliveryTag());
} else {
    print "[x] pas de commandes\n"; exit(0);
}
$channel->close();
$connection->close();