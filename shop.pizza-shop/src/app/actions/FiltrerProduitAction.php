<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class FiltrerProduitAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $catalogService = $this->container->get('catalog.service');
        try {

            $products = $catalogService->getProducts();
        }catch (\Exception $e){
            $response = $response->withStatus(400,401,404,500);
            $response->getBody()->write($e->getMessage());
            return $response->withHeader('Content-Type', 'application/json');
        }
        foreach ($products as $key => $product) {
            $products[$key]['uri'] = "http://localhost:2080/produits/keyword=" . $product['keyword'];
        }
        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json');
        $response->withStatus(200,201);

    }
}