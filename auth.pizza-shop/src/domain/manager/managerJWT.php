<?php

namespace pizzashop\auth\api\domain\manager;
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException ;
use Firebase\JWT\BeforeValidException;

class managerJWT implements IManagerJWT
{
    public function __construct()
    {}

    public function createToken($data)
    {
        // TODO: Implement createToken() method.
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