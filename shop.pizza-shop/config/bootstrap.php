<?php


use pizzashop\shop\domain\service\utils\Eloquent;
use Slim\Factory\AppFactory as Factory;


$app = Factory::create();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);


Eloquent::init(__DIR__ . '/../conf/catalog.db.ini.template');
Eloquent::init(__DIR__ . '/../conf/command.db.ini.template');

$settings = require_once __DIR__ . '/settings.php';
$dependencies = require_once __DIR__.'/services_dependencies.php';
$actions= require_once __DIR__.'/actions_dependencies.php';

$builder = new ContainerBuilder();
$builder->addDefinitions($settings );
$builder->addDefinitions($dependencies);
$builder->addDefinitions($actions);
$c=$builder->build();
$app = AppFactory::createFromContainer($c);

return $app;        