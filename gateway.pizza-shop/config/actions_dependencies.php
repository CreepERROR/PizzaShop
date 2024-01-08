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
                'base_uri' => 'api.pizza-shop',
                'headers' => [
                    'Accept' => 'application/json',
                    'Origin' => '',
                    'Authorization' => 'bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwODAvIiwic3ViIjoicGl6emEtc2hvcC5kYiIsImF1ZCI6InBpenphc2hvcGNvbXBvbmVudHMtYXBpLnBpenphLWF1dGgtMSIsImlhdCI6MTcwNDY2MjA0NCwiZXhwIjoxNzA0NjY1NjQ0LCJ1c2VybmFtZSI6IkFsaXhQZXJyb3QifQ.EvCNS4Nnj4KrNoWYlkboTuy4wyiwAxjMDRuNHQbDvGY'
                ]
            ]
        );
    },
];