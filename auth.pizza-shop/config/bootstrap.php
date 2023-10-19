<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory as Factory;
use Illuminate\Database\Capsule\Manager as Eloquent;

//$settings = require_once __DIR__ . '/settings.php';
$dependencies = require_once __DIR__ . '/services_dependencies.php';
$actions = require_once __DIR__ . '/actions_dependencies.php';

$builder = new ContainerBuilder();
//$builder->addDefinitions($settings);
$builder->addDefinitions($dependencies);
$builder->addDefinitions($actions);
$c = $builder->build();

$app = Factory::createFromContainer($c);


$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false)
    ->getDefaultErrorHandler()
    ->forceContentType('application/json');

$eloquent = new Eloquent();
$eloquent->addConnection(parse_ini_file(__DIR__ . '/auth.db.ini'), 'auth');
$eloquent->setAsGlobal();
$eloquent->bootEloquent();


(require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();



return $app;