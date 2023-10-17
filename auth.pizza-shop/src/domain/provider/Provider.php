<?php

namespace pizzashop\auth\api\domain\provider;


class Provider implements IProvider
{

    public function verifAuthCredentials(string $login, string $password): bool
    {
        try {
        $password=password_hash($password,PASSWORD_BCRYPT);
            Users::find()->where(['login' => $login, 'password' => $password])->one();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function verifAuthRefreshToken(string $refreshToken): bool
    {
        try {
            Users::find()->where(['refresh_token' => $refreshToken])->one();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function getProfilAuth(string $username, string $email, string $refresToken)
    {
        // TODO: Implement getProfilAuth() method.
    }
}