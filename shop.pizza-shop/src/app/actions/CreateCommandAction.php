<?php

namespace pizzashop\shop\app\actions;


use ErrorException;
use Exception;
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
            try{
                // vérif présence access token ds header
                if($request->getHeader('Authorization') == null){
                    throw new Exception('No header');
                }
                $header = $request->getHeader('Authorization')[0];
                $bearer = explode(' ', $header)[0];

                //vérif présence refresh token ds le body
                if ($request->getBody() == null) {
                    throw new Exception('No body');
                }
                $body = $request->getBody()->getContents();
                $body = json_decode($body, true);
                $refresh = $body->refresh_token;
            }catch (Exception $e) {
                $response = $response->withStatus(401);
                $response->getBody()->write($e->getMessage());
                return $response->withHeader('Content-Type', 'application/json');
            }

            //si le refresh et l'access sont bien présents, on appelle client Guzzle
            if (isset($refresh) && isset($header) && $bearer=='Bearer') {
                $access = explode(' ', $header)[1];
                    $client = new Client([
                        'base_uri' => 'http://api.pizza-auth',
                        'timeout' => 15.0,
                    ]);
                    $responseValidate = $client->request('POST', '/api/users/validate', [
                        'headers' => [
                            'Authorization' => 'Bearer'.$access
                        ],
                        'body' => json_encode($body)
                    ]);
                    $code = $responseValidate->getStatusCode();
                    if ($code != 200) {
                        throw new \Exception('Validate Token sans succès');
                    } else {
                        $bodyResponse = $responseValidate->getBody()->getContents();
                        //$response = new Response();
                        //$response->getBody()->write($bodyResponse);

                        //si tout va bien, on utilise les éléments renvoyés par validate pour créer la commande
                        $body = $request->getBody()->getContents();
                        $body = json_decode($body, true);
                        $commandeDTO = new CommandeDTO($body['mail_client'], $responseValidate['email'], $body['items']);
                        $serviceCommand = $this->container->get('command.service');

                        $validator = Validation::createValidator();
                        $valide = $serviceCommand->validateDataCommand($validator, $commandeDTO);
                        $valide = $valide->getContent();
                    }

                //création de la commande à proprement parler


                if (empty($valide)) {
                    $commandeDTO = $serviceCommand->createCommand($commandeDTO);
                    $json = json_encode($commandeDTO);
                    // Ajouter le contenu JSON à la réponse
                    $response->getBody()->write($json);
                } else {
                    $response->getBody()->write($valide);
                }

                $response = $response->withStatus(/*$json,*/ 201)->withHeader('Location', '/commandes/' . $commandeDTO->id);
            }

        } catch (\Exception $e) {
            //TODO: gérer les exceptions
            $response = $response->withStatus(400);
            $response->getBody()->write($e->getMessage());
        }

        // Définir le type de contenu de la réponse comme JSON
        return $response->withHeader('Content-Type', 'application/json');
    }
}