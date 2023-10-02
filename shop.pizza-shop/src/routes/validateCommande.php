<?php

namespace pizzashop\shop\routes;
use Illuminate\Database\Eloquent\Model;
use PDOException;
use pizzashop\shop\models\Command;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

require '../vendor/autoload.php';