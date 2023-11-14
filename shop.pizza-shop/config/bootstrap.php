<?php

//use pizzashop\shop\domain\service\utils\Eloquent;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Eloquent;

use pizzashop\shop\middleware\CorsMiddleware;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$builder = new DI\ContainerBuilder();

try {
//    $settings = require_once __DIR__ . '/settings.php';
    $dependencies = require_once __DIR__.'/services_dependencies.php';
    $actions= require_once __DIR__.'/actions_dependencies.php';
    $builder = new ContainerBuilder();
//    $builder->addDefinitions($settings );
    $builder->addDefinitions($dependencies);
    $builder->addDefinitions($actions);
    $c = $builder->build();
    $app = AppFactory::createFromContainer($c);
    $container = $app->getContainer();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app->add(new CorsMiddleware());
$twig = Twig::create('../src/templates',['cache'=>'cache/','auto_reload'=>true]);

$eloquent = new Eloquent();
$eloquent->addConnection(parse_ini_file(__DIR__ . '/commande.db.ini'), 'commande');
$eloquent->addConnection(parse_ini_file(__DIR__ . '/catalog.db.ini'), 'catalog');
$eloquent->setAsGlobal();
$eloquent->bootEloquent();

$app->add(TwigMiddleware::create($app,$twig));

//$settings = require_once __DIR__ . '/settings.php';
//$dependencies = require_once __DIR__.'/services_dependencies.php';
//$actions= require_once __DIR__.'/actions_dependencies.php';
//
//$builder = new ContainerBuilder();
//$builder->addDefinitions($settings );
//$builder->addDefinitions($dependencies);
//$builder->addDefinitions($actions);
//$c=$builder->build();
//$app = AppFactory::createFromContainer($c);

return $app;        