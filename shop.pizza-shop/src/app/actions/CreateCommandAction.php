<?php

namespace pizzashop\shop\app\actions;


use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\command\CommandService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class CreateCommandAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            $body = $request->getBody()->getContents();
            $body = json_decode($body, true);
            $commandeDTO = new CommandeDTO($body['mail_client'], $body['type_livraison'], $body['items']);
            $serviceCommand = new CommandService();
            $commandeDTO = $serviceCommand->createCommand($commandeDTO);
            $json = json_encode($commandeDTO);
            // Ajouter le contenu JSON à la réponse
            $response->getBody()->write($json);

            $response->withStatus(/*$json,*/ 201)->withHeader('Location', '/commandes/' . $commandeDTO->id);
        } catch (\Exception $e) {
            //TODO: gérer les exceptions
            $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }

        // Définir le type de contenu de la réponse comme JSON
        return $response->withHeader('Content-Type', 'application/json');
    }
}