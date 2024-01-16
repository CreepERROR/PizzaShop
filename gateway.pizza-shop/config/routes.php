<?php
declare(strict_types=1);

use pizzagataway\gate\app\actions\AccederCommandeAction;
use pizzagataway\gate\app\actions\ValiderCommandeAction;
use pizzagataway\gate\app\actions\CreateCommandAction;
use pizzagataway\gate\app\actions\SignInAction;
use pizzagataway\gate\app\actions\SignUpAction;

use pizzashop\shop\models\Command;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzagataway\gate\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/api/commandes/{id_commande}[/]', AccederCommandeAction::class)->setName('commandes');
    $app->patch('/api/commande/{id_commande}[/]', ValiderCommandeAction::class);
    $app->post('/api/commande', CreateCommandAction::class)->setName('createCommand');
    $app->post('/api/signin', SignInAction::class)->setName('signin');
    $app->post('/api/signup', SignUpAction::class)->setName('signup');


    // routes du catalogue
    $app->get('/api/produits[/]', \pizzagataway\gate\app\actions\ListerProduitsAction::class)
        ->setName('produits');
    $app->get('/papi/roduit/{id_produit}[/]', \pizzagataway\gate\app\actions\ConsulterProduitAction::class)
        ->setName('produit');
    $app->get('/api/categories/{id_categorie}/produits[/]', \pizzagataway\gate\app\actions\ListerProduitsParCategorieAction::class)
        ->setName('produits_par_categorie');



    $app->post('/api/users/signin', SignInAction::class)->setName('signin');
    $app->post('/api/users/signup', SignUpAction::class)->setName('signin');
};