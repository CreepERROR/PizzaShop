<?php

namespace pizzashop\shop\routes;

use Illuminate\Database\Eloquent\Model;
use PDOException;
use pizzashop\shop\models\Command;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

require '../vendor/autoload.php';

$app = new App($respnseFactory);

$app->get('../commande/{ID-COMMANDE}', function (Request $request, Response $response){
    $access = Command::where('id', '=', $request)->first();
    try
    {
        $id = isset($access['id']);
        $response->getBody()->write("id : $id");
        return $response
        ->withHeader('content-type','application/json')
        ->withStatus('200');
    }
    catch (PDOException $e)
    {
        $error= array (
            'message' => $e->getMessage()
        );

        $response->getBody()->write(json_encode($error));
        return $response
        ->withHeader('content-type','application/json')
        ->withStatus('404')
        ->withStatus('500');
    }
    
});

$app->run();
?>