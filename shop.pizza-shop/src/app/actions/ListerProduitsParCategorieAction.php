<?php

namespace pizzashop\shop\app\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ListerProduitsParCategorieAction extends AbstractAction
{

    /**
     * retourne la liste des produits
     * d'une catégorie.
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $catalogService = $this->container->get('catalog.service');
        try {

                $products = $catalogService->getProductsByCategory($args['id_categorie']);
        }catch (\Exception $e){
            $response = $response->withStatus(405);
            $response->getBody()->write($e->getMessage());
            return $response->withHeader('Content-Type', 'application/json');
        }
        foreach ($products as $key => $product) {
            $products[$key]['uri'] = "http://localhost:2080/produit/" . $product['id'];
        }
        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json');

    }
}