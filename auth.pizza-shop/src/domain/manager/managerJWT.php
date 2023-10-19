<?php

namespace pizzashop\auth\api\domain\manager;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;

class managerJWT implements IManagerJWT
{
    private $secret;
    private $entete;
    private $payload;
    private $token;
    
    public function __construct()
    {
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
    }

    public function createToken($data)
    {
    $users = Users::all($data);

    foreach ($users as $user){
        $payload = [
            "iss" => $this->payload['iss'],
            "sub" => $data['sub'],
            "aud" => $this->payload['aud'],
            "iat" => $this->payload['iat'],
            "exp" => $this->payload['exp']
        ];
    
        // Encodez le jeton JWT avec les données utilisateur
        $token = JWT::encode($user,$_ENV['SECRET_KEY'] , 'HS512');
    
        return $token;
    }
    
    }

    public function validateToken($token)
    {
        // TODO: Implement validateToken() method.
        try {
            $header = $token->getHeader('Authorization')[0] ;
            $tokenstring = sscanf($header, "Bearer %s")[0] ;
            $token = JWT::decode ($tokenstring, new Key($_ENV['SECRET_KEY'],'HS512' ));
            return $token;
            }
        
            catch (ExpiredException $e) {
                return 'votre token est expiré';
            } 
            catch (SignatureInvalidException $e) {
                return 'votre signature est invalide';
            } 
            catch (BeforeValidException $e) {
                return 'exception non valide';
            } 
            catch (\UnexpectedValueException $e) { }
    }
}