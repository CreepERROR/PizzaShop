<?php
use PhpAmqpLib\Message\AMQPMessage;
use \PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__ . '/../../vendor/autoload.php';

$message_queue = 'nouvelles_commandes';
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
$channel = $connection->channel();
$msg_body = [ 'commande' => ' azertyuiop', 'nom' => 'gehzjak', 'prix' => 8.5, 'quantite' => 1, 'client' => 'Jean' ] ;
$channel->basic_publish(new AMQPMessage(json_encode($msg_body)), 'pizzashop'
    , 'nouvelle');

print "[x] commande publiée : \n";
print_r($msg_body);
$channel->close();
$connection->close();