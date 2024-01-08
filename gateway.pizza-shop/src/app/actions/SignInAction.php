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
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->post('/signin', [
            'json' => $request->getParsedBody()
        ]);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;
    }
}