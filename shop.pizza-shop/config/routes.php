<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commandes');
};