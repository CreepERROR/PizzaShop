<?php

namespace pizzagataway\gate\app\actions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use HttpException;
use pizzashop\shop\domain\service\command\CommandService;
use pizzashop\shop\domain\service\exception\CommandeNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ValiderCommandeAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $guzzle = $this->container->get('guzzle.client');
            $res = $guzzle->patch('/commande/'.$args['id_commande'], [
                'body' => $request->getBody()->getContents()
            ]);
            $res = $res->getBody()->getContents();
            $response->getBody()->write($res);
            $response->withHeader('Content-Type', 'application/json');
            return $response;
        } catch (Exception $e){
            $code = $e->getCode();
            $response = $response->withStatus($code);
            $response->getBody()->write($e->getMessage());
            return $response->withHeader('Content-Type', 'application/json');
        }

    }
}
