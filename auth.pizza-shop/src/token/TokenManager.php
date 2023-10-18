<?php

namespace pizzashop\auth\api\token;

require 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;

class tokenManager {

    private $secret;
    private $entete;
    private $payload;
    private $token;

    public function __construct ($secret,$entete,$payload, $token){

        $this->secret=$_ENV['SECRET_KEY'];
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
        $this->token= JWT::encode($payload, $secret, 'HS512');
    }

    public function decodeAccessToken($secret,$rq){

        try {
        $h = $rq->getHeader('Authorization')[0] ;
        $tokenstring = sscanf($h, "Bearer %s")[0] ;
        $token = JWT::decode ($tokenstring, new Key($secret,'HS512' ));
        return $token;
        }
    
        catch (ExpiredException $e) {} 
        catch (SignatureInvalidException $e) {} 
        catch (BeforeValidException $e) {} 
        catch (\UnexpectedValueException $e) { }

    }       

}



?>
