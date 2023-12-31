<?php

namespace pizzashop\auth\api\app\actions;

//manque use pr le service et pr l'exception
// TODO: Ajouter les use nécessaires
use pizzashop\auth\api\app\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\auth\api\domain\provider\Provider;
use pizzashop\auth\api\domain\manager\ManagerJWT;
use pizzashop\auth\api\domain\service\ServiceAuth;


class RefreshAuthAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getHeader('Authorization')[0];
            $token = explode(' ', $body)[1];
            $serviceAuth = $this->container->get('auth.service');
            $result = $serviceAuth->refresh($token);
            if (empty($result)) {
                $response = $response->withStatus(401);
                $errorMessage = array (
                    "error" => "NON",
                    "message" => "Le refresh du token n'a pas fonctionne"
                );
                $errorMessage = json_encode($errorMessage);
                $response->getBody()->write($errorMessage);
            } else {
                $response = $response->withStatus(200);
                $tokens = array (
                    "access_token" => $result['access_token'],
                    "refresh_token" => $result['refresh_token']
                );
                $tokens = json_encode($tokens);
                $response->getBody()->write($tokens);
            }
        } catch (\Exception $e) {
            $response = $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
