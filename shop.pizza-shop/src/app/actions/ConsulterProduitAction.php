<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\domain\service\catalog\CatalogService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ConsulterProduitAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $catalogService = new CatalogService();
        $product = $catalogService->getProduct($args['id_produit']);
        $response->getBody()->write(json_encode($product));
        return $response->withHeader('Content-Type', 'application/json');
    }
}