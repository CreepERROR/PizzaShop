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


        try {

            $access = $request->getHeader('Authorization')[0];
            $bodyReq = $request->getBody()->getContents();
            $client = new Client([
                'base_uri' => 'http://api.pizza-shop',
                'timeout' => 15.0,
            ]);
            $responseCreate = $client->request('POST', '/createCommand', [
                'headers' => [
                    'Authorization' => $access,
                    'Origin' => '*'
                ],
                'body' => $bodyReq
            ]);

            $res = $responseCreate->getBody()->getContents();
            $response->getBody()->write($res);
            return $response->withHeader('Content-Type', 'application/json');
        } catch (Exception $e){
            $response = $response->withStatus(401);
            $response->getBody()->write($e->getMessage());
            return $response->withHeader('Content-Type', 'application/json');
        }





    }
}