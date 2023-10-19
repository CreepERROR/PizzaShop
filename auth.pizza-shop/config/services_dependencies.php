<?php


return[
    'commande.logger' => function(\Psr\Container\ContainerInterface $c){
        $log = new \Monolog\Logger($c->get('log.commande.name'));
        $log->pushHandler(new \Monolog\Handler\StreamHandler($c->get('log.commande.file'), $c->get('log.commande.level')));
        return $log;
    },
    'managerJWT' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\auth\api\domain\manager\managerJWT();
    },
    'provider' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\auth\api\domain\provider\provider();
    }
];
