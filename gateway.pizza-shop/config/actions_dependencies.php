<?php

return[
  'command.service' => function(\Psr\Container\ContainerInterface $c){
      return new \pizzashop\shop\domain\service\command\CommandService();
  },
    'catalog.service' => function(\Psr\Container\ContainerInterface $c){
        return new \pizzashop\shop\domain\service\catalog\CatalogService();
    },
    'guzzle.client' => function(\Psr\Container\ContainerInterface $c){
        return new \GuzzleHttp\Client(
            [
                'base_uri' => 'http://api.pizza-shop',
                'headers' => [
                    'Accept' => 'application/json',
                    'Origin' => '*'
                ]
            ]
        );
    },
];