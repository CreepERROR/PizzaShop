<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class AbstractAction
{
    abstract public function __invoke(Request $request, Response $response, $args): Response;
}