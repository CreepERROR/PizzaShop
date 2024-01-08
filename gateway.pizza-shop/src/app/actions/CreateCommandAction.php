<?php

namespace pizzagataway\gate\app\actions;


use ErrorException;
use Exception;
use GuzzleHttp\Client;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\command\CommandService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Component\Validator\Validation;


class CreateCommandAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->post('/createCommand', [
            'json' => $request->getParsedBody()
        ]);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}