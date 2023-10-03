<?php

use pizzashop\shop\domain\service\utils\Eloquent;
use Slim\Factory\AppFactory as Factory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;


$app = Factory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$twig = Twig::create('../src/templates',['cache'=>'cache/','auto_reload'=>true]);

Eloquent::init('catalog.db.ini');
Eloquent::init('commande.db.ini');
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