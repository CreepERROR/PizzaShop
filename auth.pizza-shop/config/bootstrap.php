<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory as Factory;
use Illuminate\Database\Capsule\Manager as Eloquent;

//$settings = require_once __DIR__ . '/settings.php';
$dependencies = require_once __DIR__ . '/action_dependencies.php';
//$actions = require_once __DIR__ . '/actions.php';

$builder = new ContainerBuilder();
//$builder->addDefinitions($settings);
$builder->addDefinitions($dependencies);
//$builder->addDefinitions($actions);
try {
    $c = $builder->build();
} catch (Exception $e) {
}
$app = Factory::create();


$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false)
    ->getDefaultErrorHandler()
    ->forceContentType('application/json');

$eloquent = new Eloquent();
   $eloquent ->addConnection(parse_ini_file(__DIR__ . '/auth.db.ini'), 'auth');


(require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();



return $app;