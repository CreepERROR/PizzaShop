<?php

namespace pizzagataway\gate\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListerProduitsAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $guzzle = $this->container->get('guzzle.client');
        $response = $guzzle->get('/produits');
        return $response;

    }
}