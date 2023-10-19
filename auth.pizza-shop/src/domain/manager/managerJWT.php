<?php

namespace pizzashop\auth\api\domain\manager;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use pizzashop\auth\api\models\Users;


class managerJWT implements IManagerJWT
{
    private $secret;
    private $entete;
    private $payload;
    private $token;
    
    public function __construct()
    {
        $this->secret=getenv('SECRET_KEY');
        $this->entete= [
            "alg" => "HS512", // hashing
            "typ" => "JWT" // type
        ];;
         $this->payload=[
             "iss" => "http://localhost:8080/", // issuer, émetteur du token
             "sub" => "pizza-shop.db", // Subject
             "aud" => "pizzashopcomponents-api.pizza-auth-1",//audience, utilisateur du token
             "iat" => time(), // Heure d'émission
             "exp" => time() + 3600 // Heure d'expiration
         ];
    }

    public function createToken($data)
    {
    $users = Users::where('users','email','password');

    foreach ($users as $user){
    }
    
    }

    public function validateToken($token)
    {
        // TODO: Implement validateToken() method.
        $users = Users::where($token);
        if ($users == new Key(getenv('SECRET_KEY'))) {
            $payload = ["iss" => "http://localhost:8080/", // issuer, émetteur du token
            "sub" => "pizza-shop.db", // Subject
            "aud" => "pizzashopcomponents-api.pizza-auth-1",//audience, utilisateur du token
            "iat" => time(), // Heure d'émission
            "exp" => time() + 3600 // Heure d'expiration
        ];

            return $payload;
        }
    }
        
           
    }