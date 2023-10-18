<?php

namespace pizzashop\auth\api\domain\provider;


class Provider implements IProvider
{
    public function __construct()
    {}

    /**
     * @param string $login
     * @param string $password
     * @return refreshToken je crois !!!! Pas sur, redis moi
     */
    public function verifAuthCredentials(string $login, string $password)
    {
        //TODO: verifier les credentials dans firebase
    }

    public function verifAuthRefreshToken(string $refreshToken)
    {
     //Todo: verifier le refresh token dans firebase
    }

    public function getProfilAuth(string $username, string $email, string $refresToken)
    {
        // TODO: Implement getProfilAuth() method.
    }
}