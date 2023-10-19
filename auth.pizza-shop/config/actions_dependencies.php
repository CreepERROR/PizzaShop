<?php

return[
    'auth.service' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\auth\api\domain\service\ServiceAuth($c);
    }
];