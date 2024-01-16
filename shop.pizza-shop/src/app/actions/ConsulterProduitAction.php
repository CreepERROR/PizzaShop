<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ConsulterProduitAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $catalogService = $this->container->get('catalog.service');
        try {
            $product = $catalogService->getProduct($args['num_produit']);
        }catch ( \Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            $response = $response->withStatus(404);
            return $response->withHeader('Content-Type', 'application/json');
        }
        $response = $response->withStatus(200);
        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json');
    }
}