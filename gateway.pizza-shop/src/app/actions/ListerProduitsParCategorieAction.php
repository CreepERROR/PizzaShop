<?php

namespace pizzagataway\gate\app\actions;

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
        $products = $catalogService->getProductsByCategory($args['id_categorie']);
        foreach ($products as $key => $product) {
            $products[$key]['uri'] = "http://localhost:2080/produit/" . $product['id'];
        }
        $response->getBody()->write(json_encode($products));
        return $response->withHeader('Content-Type', 'application/json');

    }
}