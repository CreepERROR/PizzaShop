<?php

namespace pizzashop\shop\app\actions;

use ErrorException;
use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\command\CommandService;
use pizzashop\shop\domain\service\exception\CommandeNotFoundException;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ValiderCommandeAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $id = $args['id_commande'];
            $requ = $request->getBody()->getContents();
            $requ = json_decode($requ, true);
            $etat = $requ['etat'];
            $serviceCommande = $this->container->get('command.service');
            $commande = $serviceCommande->validateCommand($id);
            while (true) {


                try {
                    $rmqConnexion = $this->container->get('rabbitmq.connexion');
                    $rmqChannel = $this->container->get('rabbitmq.channel');
                    $rmqMessage = $this->container->get('rabbitmq.message');
                    $rmqMessage->setBody(json_encode($commande));
                    $rmqChannel->basic_publish($rmqMessage, 'pizzashop', 'nouvelle');
                    $rmqChannel->close();
                    $rmqConnexion->close();
                } catch (Exception $e) {
                    $response = $response->withStatus(400);
                    $response->getBody()->write('Erreur RabbitMQ     :    ' . $e->getMessage());
                }
            }

            //pq c jamais TRUE ALO  RS QUE Y A RIEN (qd mauvais id)
            if (!is_null($commande)) {
                if ($commande['etat'] !== $etat) {
                    $response = $response->withStatus(400);
                } else {
                    $commandeFormated = [
                        $commande,
                        'links' => [
                            'commandes' => [
                                'href' => '/commandes/' // Utilisez l'URL relative directement
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

                }
            } else {
                $response = $response->withStatus(404);
            }

        } catch (CommandeNotFoundException $e) {
            throw new HttpInternalServerErrorException($request, $e->getMessage());
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}
