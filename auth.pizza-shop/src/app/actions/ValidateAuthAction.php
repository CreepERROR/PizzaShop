<?php

namespace pizzashop\auth\api\app\actions;

//manque use pr le service et pr l'exception
// TODO: Ajouter les use nécessaires
use pizzashop\auth\api\app\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\auth\api\domain\service\ServiceAuth;
use pizzashop\auth\api\domain\provider\Provider;
use pizzashop\auth\api\domain\manager\ManagerJWT;

class ValidateAuthAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getHeader('Authorization')[0];
            $token = explode(' ', $body)[1];
            $serviceAuth = $this->container->get('auth.service');
            $body = $request->getBody()->getContents();
            $data = json_decode($body, true);
            $token = [0=>$token, 1=>$data];
            $result = $serviceAuth->validate($token);
            if (empty($result)) {
                //TODO : faire distinction expiré et invalide
                $response->withStatus(401);
                $errorMessage = array (
                    "error" => "Unauthorized",
                    "message" => "Votre validation a echoue!!"
                );
                $errorMessage = json_encode($errorMessage);
                $response->getBody()->write($errorMessage);
            } else {
                $response->withStatus(200);
                $userInfo = array (
                    "username" => $result['username'],
                    "email" => $result['email'],
                );
                $userInfo = json_encode($userInfo);
                $response->getBody()->write($userInfo);
            }

        } catch (\Exception $e) {
            $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }
        return $response->withHeader('Content-Type', 'application/json');
    }
}
