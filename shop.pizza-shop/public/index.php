<?php
declare(strict_types=1);


require __DIR__ . '/vendor/autoload.php';


require_once __DIR__ . '/../vendor/autoload.php';

/* application boostrap */
$app = require_once __DIR__ . '/../config/bootstrap.php';

/* Routes loading */
(require_once __DIR__ . '/../config/routes.php')($app);

$app->run();
