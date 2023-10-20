<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\CreateCommandAction;
use pizzashop\shop\app\actions\SignInAction;

use pizzashop\shop\models\Command;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commandes');
    $app->patch('.../commande/{ID}', Command::class);
    $app->post('/createCommand', CreateCommandAction::class)->setName('createCommand');
    $app->post('/signin', SignInAction::class)->setName('signin');

};