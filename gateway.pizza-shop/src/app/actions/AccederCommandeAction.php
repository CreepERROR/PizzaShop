<?php

namespace pizzagataway\gate\app\actions;

use pizzagataway\gate\app\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AccederCommandeAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $guzzle = $this->container->get('guzzle.client');
        $response = $guzzle->get('/commandes/' . $args['id_commande']);
        return $response;
    }
}
