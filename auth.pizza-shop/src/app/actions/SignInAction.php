<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\app\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\auth\api\domain\service\ServiceAuth;
use pizzashop\auth\api\domain\provider\Provider;
use pizzashop\auth\api\domain\manager\ManagerJWT;




class SignInAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getHeader('Authorization')[0];
            $body = explode(' ', $body)[1];
            $body = base64_decode($body);
            $username = explode(':', $body)[0];
            $password = explode(':', $body)[1];
            $credentials = array (
                "username" => $username,
                "password" => $password
            );
            //pas comme ça qu'on appelle le service
            //manque injections de dépendance ?
            $provider = new Provider();
            $managerJWT = new ManagerJWT();
            $serviceAuth = new ServiceAuth($provider, $managerJWT);
           // $serviceAuth = $this->container->get('auth.service');

            $result = $serviceAuth->signin($credentials);
            if (empty($result)) {
                $response->withStatus(401);
                $errorMessage = array (
                    "error" => "Unauthorized",
                    "message" => "Votre identifiation a echoue!!"
                );
                $errorMessage = json_encode($errorMessage);
                $response->getBody()->write($errorMessage);
            } else {
                $response->withStatus(200);
                $tokens = array (
                    "access_token" => $result['access_token'],
                    "refresh_token" => $result['refresh_token']
                );
                $tokens = json_encode($tokens);
                $response->getBody()->write($tokens);
            }


        } catch (\Exception $e) {
            //TODO: gérer les exceptions
            $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }

        return $response->withHeader('Content-Type', 'application/json');

    }
}
