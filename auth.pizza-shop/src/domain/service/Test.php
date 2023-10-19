<?php

namespace pizzashop\auth\api\domain\service;

use TestAuth;
use PHPUnit\Framework\TestCase;
use pizzashop\auth\api\models\Users;


class Test extends TestCase
{
    public function test()
    {

      Users::where('username', '=', 'AlixPerrot')->first();


    }
}
