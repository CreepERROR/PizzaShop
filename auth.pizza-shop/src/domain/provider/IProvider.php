<?php

namespace pizzashop\auth\api\domain\provider;
use Kreait\Firebase\Auth\SignInWithRefreshToken;

interface IProvider
{

    public function verifAuthCredentials(string $login, string $password);

    public function verifAuthRefreshToken(string $refreshToken);
    public function getProfilAuth(string $username, string $email, string $refresToken);


}