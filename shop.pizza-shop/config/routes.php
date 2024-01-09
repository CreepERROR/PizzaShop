<?php
declare(strict_types=1);

use pizzashop\shop\app\actions\AccederCommandeAction;
use pizzashop\shop\app\actions\ValiderCommandeAction;
use pizzashop\shop\app\actions\CreateCommandAction;
use pizzashop\shop\app\actions\SignInAction;
use pizzashop\shop\app\actions\SignUpAction;

use pizzashop\shop\app\actions\ListerProduitsAction;
use pizzashop\shop\app\actions\ConsulterProduitAction;
use pizzashop\shop\app\actions\ListerProduitsParCategorieAction;

use pizzashop\shop\models\Command;
use Slim\App;

return function(App $app) {

    //$app->post('/commandes[/]', \pizzashop\shop\app\actions\CreerCommandeAction::class)
    //    ->setName('creer_commande');

    $app->get('/commandes/{id_commande}[/]', AccederCommandeAction::class)
        ->setName('commandes');
    $app->patch('/commande/{id_commande}[/]', ValiderCommandeAction::class);
    $app->post('/createCommand', CreateCommandAction::class)->setName('createCommand');
    $app->post('/signin', SignInAction::class)->setName('signin');
    $app->post('/signup', SignUpAction::class)->setName('signup');


    // routes du catalogue
    $app->get('/produits[/]', ListerProduitsAction::class)
        ->setName('produits');
    $app->get('/produit/{num_produit}[/]', ConsulterProduitAction::class)
        ->setName('produit');
    $app->get('/categories/{id_categorie}/produits[/]', ListerProduitsParCategorieAction::class)
        ->setName('produits_par_categorie');
};