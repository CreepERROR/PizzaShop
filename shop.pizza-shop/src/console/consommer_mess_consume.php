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
$callback = function(AMQPMessage $msg) {
    $msg_body = json_decode($msg->body, true); print "[x] message reçu : \n";
    $msg->getChannel()->basic_ack($msg->getDeliveryTag());
};
$msg = $channel->basic_consume($message_queue,
    '', false, false, false, false, $callback );
try {
    $channel->consume();
} catch (Exception $e)
{
    print $e->getMessage();
}
$channel->close();
$connection->close();