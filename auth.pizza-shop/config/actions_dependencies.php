<?php

return[
    'command.service' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\shop\domain\service\command\CommandService();
    },
];