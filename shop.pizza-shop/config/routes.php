<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\models\Command;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commandes');

    $app->patch('.../commande/{ID}', Command::class)
    ->withJson($commandeDTO)->withStatus(200)
    ->withStatus(404)->withJson(['message' => 'Utilisateur non trouvé'])
    ->withStatus(400)->withJson(['message' => 'Requête invalide'])
    ->withStatus(500)->withJson(['message' => 'Erreur interne du serveur']);
};