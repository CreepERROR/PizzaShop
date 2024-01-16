<?php

namespace pizzagataway\gate\app\actions;
use GuzzleHttp\Client;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class SignUpAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        /*
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->post('users/signup', [
            'json' => $request->getParsedBody()
        ]);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
        */

        try {
            $body = $request->getBody()->getContents();

            $client = new Client([
                'base_uri' => 'http://api.pizza-shop',
                'timeout' => 15.0,
            ]);
            $response = $client->request('POST', '/signup', [
                'headers' => [
                    'Authorization' => $request->getHeader('Authorization'),
                    'Origin' => '*'
                ],
                'body' => $body
            ]);
            $code = $response->getStatusCode();
            if ($code != 200) {
                throw new \Exception('Autorisation invalide');
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