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
        $guzzle = $this->container->get('guzzle.client');
        $res = $guzzle->get('/produits/categorie/' . $args['id_categorie']);
        $res = $res->getBody()->getContents();
        $response->getBody()->write($res);
        return $response;

    }
}