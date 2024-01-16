<?php

namespace pizzashop\shop\app\actions;
use GuzzleHttp\Client;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class SignUpAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getBody()->getContents();

            $client = new Client([
                'base_uri' => 'http://api.pizza-auth',
                'timeout' => 15.0,
            ]);
            $response = $client->request('POST', '/api/users/signup', [
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
                'body' => $body
            ]);
            $code = $response->getStatusCode();
            if ($code != 200) {
                throw new \Exception('Inscription invalide');
            } else {
                $body = $response->getBody()->getContents();
                $response = new Response();
                $response->getBody()->write($body);
            }
        }catch (\Error $e){
            $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}