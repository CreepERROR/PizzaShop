<?php

namespace provider;
interface IProvider
{

    public function verifAuthCredentials(string $login, string $password): bool;

    public function verifAuthRefreshToken(string $refreshToken): bool;
    public function getProfilAuth(string $username, string $email, string $refresToken);


}