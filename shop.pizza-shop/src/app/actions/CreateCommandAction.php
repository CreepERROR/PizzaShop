<?php

namespace pizzashop\shop\app\actions;


use GuzzleHttp\Client;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\command\CommandService;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Component\Validator\Validation;


class CreateCommandAction extends AbstractAction
{

    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {

            //jsp si c utile de vérifier que le header est bien en mode bearer mais bon
            $header = $request->getHeader('Authorization')[0];
            $bearer = explode(' ', $header)[0];
            if (isset($bearer) && $bearer=='Bearer') {
                $token = explode(' ', $header)[1];
                //faire validate le token ?

                //création de la commande à proprement parler
                $body = $request->getBody()->getContents();
                $body = json_decode($body, true);
                $commandeDTO = new CommandeDTO($body['mail_client'], $body['type_livraison'], $body['items']);
                $serviceCommand = $this->container->get('command.service');

                $validator = Validation::createValidator();
                $valide = $serviceCommand->validateDataCommand($validator, $commandeDTO);
                $valide = $valide->getContent();

                if (empty($valide)) {
                    $commandeDTO = $serviceCommand->createCommand($commandeDTO);
                    $json = json_encode($commandeDTO);
                    // Ajouter le contenu JSON à la réponse
                    $response->getBody()->write($json);
                } else {
                    $response->getBody()->write($valide);
                }

                $response->withStatus(/*$json,*/ 201)->withHeader('Location', '/commandes/' . $commandeDTO->id);
            }

        } catch (\Exception $e) {
            //TODO: gérer les exceptions
            $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }

        // Définir le type de contenu de la réponse comme JSON
        return $response->withHeader('Content-Type', 'application/json');
    }
}