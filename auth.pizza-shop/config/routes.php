<?php
declare(strict_types=1);

use pizzashop\auth\api\app\actions\SignInAction;
use pizzashop\auth\api\app\actions\ValidateAuthAction;
use pizzashop\auth\api\app\actions\RefreshAuthAction;
use pizzashop\auth\api\app\actions\TestAuthAction;
use Slim\App;

return function(App $app) {
    $app->get('/api/users/test', TestAuthAction::class)->setName('testauth');
    $app->get('/api/users/validate', ValidateAuthAction::class)->setName('validateauth');
    $app->post('/api/users/signin', SignInAction::class)->setName('signin');
    $app->post('/api/users/refresh', RefreshAuthAction::class)->setName('refresh');
};