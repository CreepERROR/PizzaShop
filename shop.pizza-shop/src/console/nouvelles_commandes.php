<?php


require_once __DIR__ . '/vendor/autoload.php';

use \PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();


$channel->queue_declare('nouvelles_commandes', false, true, false, false);

echo "En attente de messages. Appuyez sur Ctrl+C pour quitter.\n";


$callback = function ($msg) {

    $message_data = json_decode($msg->body, true);


    echo "Message reçu: " . json_encode($message_data) . "\n";

    
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};


$channel->basic_consume('nouvelles_commandes', '', false, false, false, false, $callback);


while (count($channel->callbacks)) {
    $channel->wait();
}


$channel->close();
$connection->close();
