<?php

namespace pizzashop\auth\api\domain\provider;
use pizzashop\auth\api\models\Users;


use pizzashop\auth\api\domain\manager\managerJWT;

class Provider implements IProvider
{
    public function __construct()
    {}

    /**
     * @param string $login
     * @param string $password
     * @return string|null
     */
    public function verifAuthCredentials(string $login, string $password)
    {
        $user = Users::where('username', $login)->first();
        if ($user && password_verify($password, $user->password)) {
            return $user; // Renvoie le refresh token
        }
        return null; // Renvoie null si l'authentification échoue
    }

    public function verifAuthRefreshToken(string $refreshToken)
    {
        $user = Users::where('refresh_token', $refreshToken)->first();
        if ($user && strtotime($user->refresh_token_expiration_date) > time()) {
            return true;
        }
        return false;
    }

    public function getProfilAuth(string $username, string $refreshToken)
    {

        $user = Users::where('username', $username)->first();
        if ($user && $user->refresh_token === $refreshToken) {
            return [
                'username' => $user->username,
                'email' => $user->email,
                'refresh_token' => $user->refresh_token,
                'id' => $user->id
            ];
        }
        return null;
    }
}