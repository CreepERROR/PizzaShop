<?php

namespace pizzashop\auth\api\actions;

//manque use pr le service et pr l'exception
// TODO: Ajouter les use nécessaires
use pizzashop\auth\api\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ValidateAuthAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        //TODO: Ajouter le code de l'action Validate Auth
    }
}
