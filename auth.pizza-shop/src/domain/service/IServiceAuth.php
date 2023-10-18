<?php

namespace pizzashop\auth\api\domain\service;
interface IServiceAuth
{
    public function signin($credentials);

    public function validate($access_token);

    public function refresh($refresh_token);

    public function signup($credentials);

    public function activate($token);
}