<?php

namespace pizzashop\auth\api\service\authService;

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Slim\Psr7\Request;
use Slim\Psr7\Response;