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
                    throw new Exception("Pas de token dans le header d'authorization");
                }
                $header = $request->getHeader('Authorization')[0];
                $bearer = explode(' ', $header)[0];
                //var_dump($bearer);

                //vérif présence refresh token ds le body
                if ($request->getBody() == null) {
                    throw new Exception('No body');
                }
                $body = $request->getBody()->getContents();
                $body = json_decode($body, true);
                $refresh = $body['refresh_token'];

                //var_dump($refresh);

            }catch (Exception $e) {
                $response = $response->withStatus(405);
                $response->getBody()->write($e->getMessage());
                return $response->withHeader('Content-Type', 'application/json');
            }

            //si le refresh et l'access sont bien présents, on appelle client Guzzle
            if (isset($refresh) && isset($header) && $bearer=='Bearer') {
                $access = explode(' ', $header)[1];
                //var_dump($access);

                $client = new Client([
                        'base_uri' => 'http://api.pizza-auth',
                        'timeout' => 15.0,
                    ]);
                    $responseValidate = $client->request('GET', '/api/users/validate', [
                        'headers' => [
                            'Authorization' => 'Bearer '.$access
                        ],
                        'body' => json_encode($body)
                    ]);
                    $code = $responseValidate->getStatusCode();
                    if ($code != 200) {

                        $response = $response->withStatus($code);
                        return $response->withHeader('Content-Type', 'application/json');

                    } else {
                        $bodyResponse = $responseValidate->getBody()->getContents();
                        $bodyResponse = stripslashes(html_entity_decode($bodyResponse));
                        $bodyResponse=json_decode($bodyResponse,true);
                        $userMail = $bodyResponse['email'];
                        $userName = $bodyResponse['username'];

                        //création de la commande à proprement parler
                        //si tout va bien, on utilise les éléments renvoyés par validate pour créer la commande
                        $body = $request->getBody()->getContents();
                        $body = json_decode($body, true);
                        //var_dump($body);
                        $commandeDTO = new CommandeDTO($userMail, $body['type_livraison'], $body['items']);
                        $serviceCommand = $this->container->get('command.service');

                        $validator = Validation::createValidator();
                        try{

                            $valide = $serviceCommand->validateDataCommand($validator, $commandeDTO);
                        }catch (Exception $e) {
                            $response = $response->withStatus(405);
                            $response->getBody()->write($e->getMessage());
                            return $response->withHeader('Content-Type', 'application/json');
                        }
                        $valide = $valide->getContent();

                        if (empty($valide)) {
                            $commandeDTO = $serviceCommand->createCommand($commandeDTO);
                            $json = json_encode($commandeDTO);
                            // Ajouter le contenu JSON à la réponse
                            $response->getBody()->write($json);
                        } else {
                            $response->getBody()->write($valide);
                        }
                    }

                $response = $response->withStatus(/*$json,*/ 201);
                    //->withHeader('Location', '/commandes/' . $commandeDTO->id);
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