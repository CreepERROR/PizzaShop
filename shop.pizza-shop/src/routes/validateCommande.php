<?php

namespace pizzashop\shop\routes;
use Illuminate\Database\Eloquent\Model;
use pizzashop\shop\models\Command;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app = new \Slim\App();

$app->patch('.../commandes/{ ID-COMMANDE }', function ($request, $response, $args) {
    $userId = $args['id'];
    $requestData = $request->getParsedBody();

    // Recherche de l'utilisateur par son identifiant
    $utilisateur = Command::find($userId);

    if ($utilisateur) {
        // Met à jour les attributs de l'utilisateur
        $utilisateur->fill($requestData);
        $utilisateur->save();

        // Répond avec les données mises à jour de l'utilisateur
        return $response->withJson($utilisateur);
    } else {
        return $response
        ->withStatus(404)->withJson(['message' => 'Utilisateur non trouvé'])
        ->withStatus(400)->withJson(['message' => 'Requête invalide'])
        ->withStatus(500)->withJson(['message' => 'Erreur interne du serveur']);
    }
});

$app->run();
