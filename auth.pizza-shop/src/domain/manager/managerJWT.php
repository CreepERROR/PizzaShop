<?php

namespace pizzashop\auth\api\domain\manager;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use pizzashop\auth\api\models\Users;
use pizzashop\auth\api\domain\DTO\tokenDTOSignin;


class managerJWT implements IManagerJWT
{


    public function createToken($data)
    {
//        $entete= [
//                "alg" => "HS512", // hashing
//                "typ" => "JWT" // type
//            ];

        $payload=[
                "iss" => "http://localhost:8080/", // issuer, émetteur du token
                "sub" => "pizza-shop.db", // Subject
                "aud" => "pizzashopcomponents-api.pizza-auth-1",//audience, utilisateur du token
                "iat" => time(), // Heure d'émission
                "exp" => time() + 3600, // Heure d'expiration
                'username' => $data['username'],
            ];

        return JWT::encode($payload, 'secret', 'HS256');

    }

    public function validateToken($token)
    {
        $tokenDecode = JWT::decode($token, new Key( 'secret', 'HS256'));
        $tokenDecodeArray = (array)$tokenDecode;
        if($tokenDecodeArray){
            return $tokenDecodeArray['username'];
        }else{
            return false;
        }
    }
        
           
    }