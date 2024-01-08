<?php
declare(strict_types=1);

use pizzagataway\gate\app\actions\AccederCommandeAction;
use pizzagataway\gate\app\actions\CreateCommandAction;
use pizzagataway\gate\app\actions\SignInAction;

use pizzashop\shop\models\Command;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzagataway\gate\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commandes');
    $app->patch('.../commande/{ID}', Command::class);
    $app->post('/createCommand', CreateCommandAction::class)->setName('createCommand');
    $app->post('/signin', SignInAction::class)->setName('signin');


    // routes du catalogue
    $app->get('/produits[/]', \pizzagataway\gate\app\actions\ListerProduitsAction::class)
        ->setName('produits');
    $app->get('/produit/{id_produit}[/]', \pizzagataway\gate\app\actions\ConsulterProduitAction::class)
        ->setName('produit');
    $app->get('/categories/{id_categorie}/produits[/]', \pizzagataway\gate\app\actions\ListerProduitsParCategorieAction::class)
        ->setName('produits_par_categorie');
};