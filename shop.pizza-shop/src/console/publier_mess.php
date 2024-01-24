<?php
use PhpAmqpLib\Message\AMQPMessage;
use \PhpAmqpLib\Connection\AMQPStreamConnection;

require_once __DIR__ . '/../../vendor/autoload.php';
$faker = Faker\Factory::create('fr_FR');

$message_queue = 'nouvelles_commandes';
$connection = new AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
$channel = $connection->channel();
$msg_body = [
    'refresh_token' => $faker->regexify('[A-Za-z0-9]{20}'),
    'mail_client' => $email = $faker->email,
    'type_livraison' => $faker->numberBetween(1, 3),
    'items' => [
        [
            'numero' => $faker->numberBetween(1, 8),
            'taille' => $faker->numberBetween(1, 2),
            'quantite' => $faker->numberBetween(1, 5)
        ],
        [
            'numero' => $faker->numberBetween(1, 8),
            'taille' => $faker->numberBetween(1, 2),
            'quantite' => $faker->numberBetween(1, 5)
        ]
    ]
] ;
$channel->basic_publish(new AMQPMessage(json_encode($msg_body)), 'pizzashop'
    , 'nouvelle');

print "[x] commande publiée : \n";
print_r($msg_body);
$channel->close();
$connection->close();