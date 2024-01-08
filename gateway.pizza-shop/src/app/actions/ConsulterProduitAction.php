<?php

namespace pizzagataway\gate\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ConsulterProduitAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->get('/produit/' . $args['id_produit']);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}