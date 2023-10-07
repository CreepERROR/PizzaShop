<?php


return[
    'commande.logger' => function(\Psr\Container\ContainerInterface $c){
        $log = new \Monolog\Logger($c->get('log.commande.name'));
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->get('log.commande.file'), $c->get('log.commande.level')));
        return $log;
    }
];