<?php

namespace provider;

class Provider implements IProvider
{

    public function verifAuthCredentials(string $login, string $password): bool
    {
        // TODO: Implement verifAuthCredentials() method.
    }

    public function verifAuthRefreshToken(string $refreshToken): bool
    {
        // TODO: Implement verifAuthRefreshToken() method.
    }
}