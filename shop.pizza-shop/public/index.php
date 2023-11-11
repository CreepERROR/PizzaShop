<?php
declare(strict_types=1);

use pizzashop\shop\Middleware\Cors;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();


$app->add(new Cors());


require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$app = require_once __DIR__ . '/../config/bootstrap.php';

/* Routes loading */
(require_once __DIR__ . '/../config/routes.php')($app);

$app->run();
