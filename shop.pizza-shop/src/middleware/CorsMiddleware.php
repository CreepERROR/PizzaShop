<?php

namespace pizzashop\shop\Middleware\CorsMiddleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class CorsMiddleware
{
    public function __invoke(Request $rq, RequestHandler $handler): Response
    {
        if (!$rq->hasHeader('Origin')) {
            throw new HttpUnauthorizedException($rq, "missing Origin Header (cors)");
        }

        $response = $handler->handle($rq);

        $response = $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Methods', 'POST, PUT, GET')
            ->withHeader('Access-Control-Allow-Headers', 'Authorization')
            ->withHeader('Access-Control-Max-Age', '3600')
            ->withHeader('Access-Control-Allow-Credentials', 'true');

        return $response;
    }
}
