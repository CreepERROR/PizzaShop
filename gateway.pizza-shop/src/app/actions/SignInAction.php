<?php

namespace pizzagataway\gate\app\actions;
use GuzzleHttp\Client;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class SignInAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        /*
        $guzzle = $this->container->get('guzzle.client');
        echo "test";
        $res = $guzzle->post('users/signin', [
            'json' => $request->getParsedBody()
        ]);
        echo "test2";
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
        */

        try {
            $client = new Client([
                'base_uri' => 'http://api.pizza-shop',
                'timeout' => 15.0,
            ]);
            $response = $client->request('POST', '/signin', [
                'headers' => [
                    'Authorization' => $request->getHeader('Authorization'),
                    'Origin' => '*'
                ]
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