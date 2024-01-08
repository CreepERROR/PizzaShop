<?php

namespace pizzagataway\gate\app\actions;

use pizzashop\shop\domain\service\command\CommandService;
use pizzashop\shop\domain\service\exception\CommandeNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ValiderCommandeAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->post('/validerCommande', [
            'json' => $request->getParsedBody()
        ]);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}
