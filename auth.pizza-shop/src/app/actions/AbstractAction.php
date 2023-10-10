<?php

namespace pizzashop\auth\api\actions;

use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class AbstractAction
{
    protected ContainerInterface $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    abstract public function __invoke(Request $request, Response $response, $args): Response;
}