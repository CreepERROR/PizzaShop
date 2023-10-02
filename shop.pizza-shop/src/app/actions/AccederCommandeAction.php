<?php

namespace minipress\api\actions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

abstract class AccederCommandeAction
{
    public function __invoke($request, $response, $args)
    {
        $id = $args['id'];
        $serviceCommande = new CommandeService();
        try {
            $commande = $serviceCommande->getCommandeById($id);
        } catch (CommandeNotFoundException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();

        $commandeFormated = [
            $commande,
            'links' => [
                'commandes' => [
                    'href' => $routeParser->urlFor('commandes')
                ]
            ],
        ];

        $dataFormated = [
            'type' => 'ressource',
            'commande' => $commandeFormated
        ];

        // Convertir le tableau en JSON
        $json = json_encode($dataFormated);

        // Ajouter le contenu JSON à la réponse
        $response->getBody()->write($json);

        // Définir le type de contenu de la réponse comme JSON
        return $response->withHeader('Content-Type', 'application/json');

    }
}