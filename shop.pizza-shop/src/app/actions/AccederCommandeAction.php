<?php

namespace pizzashop\shop\app\actions;

use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\command\CommandService;
use pizzashop\shop\domain\service\exception\CommandeNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AccederCommandeAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = $args['id_commande'];
        $serviceCommande = new CommandService();
        try {
            $commande = $serviceCommande->readCommand($id);
        } catch (CommandeNotFoundException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }
        $commandeFormated = [
            $commande,
            'links' => [
                'commandes' => [
                    'href' => '/commandes' // Utilisez l'URL relative directement
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
