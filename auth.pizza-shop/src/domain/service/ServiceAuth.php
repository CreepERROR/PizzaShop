<?php
namespace pizzashop\auth\api\domain\service;

use pizzashop\auth\api\domain\manager\IManagerJWT;
use pizzashop\auth\api\domain\provider\IProvider;
use pizzashop\auth\api\models\Users;
use Psr\Container\ContainerInterface;

class ServiceAuth implements IServiceAuth
{
    private $provider;
    private $managerJWT;
    public function __construct(ContainerInterface $container)
    {
        $this->provider = $container->get('provider');
        $this->managerJWT = $container->get('managerJWT');
    }

    /**
     * reçoit des credentials et retourne un couple (access_token, refresh_token)
     * @param $credentials
     * @return array
     */
    public function signin($credentials)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];
        $refreshToken = $this->provider->verifAuthCredentials($username, $password);

        if($refreshToken) {
            $data = [
                'username' => $refreshToken->username,
                'email' => $refreshToken->email,
                'id' => $refreshToken->id

            ];
            $access_token = $this->managerJWT->createToken($data);
            return [
                'access_token' => $access_token,
                'refresh_token' => $refreshToken->refresh_token
            ];
        }else{
            return null;
        }


    }

    /**
     * reçoit un access_token et vérifie sa validité, puis retourne le profil de l'utilisateur
     * authentifié
     * @param $access_token
     * @return UsersDTO
     */
    public function validate($access_token)
    {
        $data = $this->managerJWT->validateToken($access_token);
        var_dump($data);
        if($data){
            $user = $this->provider->getProfilAuth($data['username'], $data['email'], $access_token);
            return $user;
        }else{
            //faire distinction entre Token invalide et Token expiré
            return null;
        }
    }

    public function refresh($refresh_token)
    {
        $data = $this->managerJWT->validateToken($refresh_token);
        if($data){
            $user = $this->provider->getProfilAuth($data['username'], $data['email'], $data['refresh_token']);
            $access_token = $this->managerJWT->createToken($user);
            $refresh_token = $this->provider->verifAuthRefreshToken($user->refresh_token);
            return [
                'access_token' => $access_token,
                'refresh_token' => $refresh_token
            ];
        }
        return null;
    }


    public function userExists($username, $email)
    {
        $user = Users::where('username', $username)->orWhere('email', $email)->first();

        return $user !== null;
    }

    public function createUser($credentials)
    {
        $username = $credentials['username'];
        $email = $credentials['email'];
        $password = password_hash($credentials['password'], PASSWORD_BCRYPT);
        $user = new Users($username,$email,$password);

        return $user;
    }


    public function signup($credentials)
    {
        // TODO: Implement signup() method
    }

    public function activate($token)
    {
        // TODO: Implement activate() method.
    }
}