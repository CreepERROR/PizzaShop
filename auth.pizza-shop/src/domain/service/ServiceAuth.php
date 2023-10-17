<?php
namespace pizzashop\auth\api\service;

class ServiceAuth implements IServiceAuth
{


    public function signin($credentials)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];

    }

    public function validate($access_token)
    {
        // TODO: Implement validate() method.
    }

    public function refresh($refresh_token)
    {
        // TODO: Implement refresh() method.
    }

    public function signup($credentials)
    {
        // TODO: Implement signup() method.
    }

    public function activate($token)
    {
        // TODO: Implement activate() method.
    }
}