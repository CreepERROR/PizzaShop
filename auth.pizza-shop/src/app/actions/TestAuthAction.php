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

class TestAuthAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $body = "blablabla";
        $body = json_encode($body);
        $response->getBody()->write($body);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
