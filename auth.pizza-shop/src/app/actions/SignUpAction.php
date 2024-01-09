<?php

namespace pizzashop\auth\api\app\actions;

use pizzashop\auth\api\app\actions\AbstractAction;
use Slim\Exception\HttpInternalServerErrorException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use pizzashop\auth\api\domain\service\ServiceAuth;
use pizzashop\auth\api\domain\provider\Provider;
use pizzashop\auth\api\domain\manager\ManagerJWT;




class SignUpAction extends AbstractAction
{
    public function __invoke(Request $request, Response $response, $args): Response
    {
        try {
            // Récupérer le contenu du corps de la requête
            $body = $request->getBody()->getContents();

            // Décoder les données JSON
            $requestData = json_decode($body, true);

            // Vérifier si le décodage a réussi
            if ($requestData !== null) {
                // Récupérer les informations d'authentification
                $username = $requestData['username'] ?? '';
                $password = $requestData['password'] ?? '';
                $email = $requestData['email'] ?? '';

                // Créer un tableau de credentials
                $credentials = [
                    "username" => $username,
                    "password" => $password,
                    "email" => $email
                ];

                // Appeler le service d'authentification
                $serviceAuth = $this->container->get('auth.service');
                $result = $serviceAuth->signup($credentials);

                if (empty($result)) {
                    $response = $response->withStatus(401);
                    $errorMessage = [
                        "error" => "Unauthorized",
                        "message" => "Votre création de compte a échoué!!"
                    ];
                    $response->getBody()->write(json_encode($errorMessage));
                } else {
                    $response = $response->withStatus(200);
                    $tokens = ["test" => "test"];
                    $response->getBody()->write(json_encode($tokens));
                }
            } else {
                // Gérer les erreurs de décodage JSON
                $response = $response->withStatus(400);
                $response->getBody()->write("Erreur de décodage JSON");
            }
        } catch (\Exception $e) {
            // Gérer les exceptions
            $response = $response->withStatus(500);
            $response->getBody()->write($e->getMessage());
        }

        return $response->withHeader('Content-Type', 'application/json');
    }
}