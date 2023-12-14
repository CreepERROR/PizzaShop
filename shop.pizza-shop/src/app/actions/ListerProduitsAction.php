<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\shop\domain\service\Catalog\CatalogService;

class ListerProduitsAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $catalogService = new CatalogService();
        $products = $catalogService->getProducts();
        foreach ($products as $key => $product) {
            $products[$key]['uri'] = "http://localhost:2080/produit/" . $product['id'];
        }
        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json');

    }
}