<?php

use \Psr\Container\ContainerInterface;
use \PhpAmqpLib\Connection;

return[
  'command.service' => function(\Psr\Container\ContainerInterface $c){
      return new \pizzashop\shop\domain\service\command\CommandService();
  },
    'catalog.service' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\shop\domain\service\catalog\CatalogService();
    },
    'rabbitmq.connexion' => function(\Psr\Container\ContainerInterface $c){
        return new \PhpAmqpLib\Connection\AMQPStreamConnection('rabbitmq', 5672, 'admin', 'admin');
    },
    'rabbitmq.channel' => function(\Psr\Container\ContainerInterface $c){
        return $c->get('rabbitmq.connexion')->channel();
    },
    'rabbitmq.message' => function(\Psr\Container\ContainerInterface $c){
        return new \PhpAmqpLib\Message\AMQPMessage();
    },
    'rabbitmq.suivi_commandes' => function(\Psr\Container\ContainerInterface $c){
        return $c->get('pizzashop.suivi')->channel();
    },
];