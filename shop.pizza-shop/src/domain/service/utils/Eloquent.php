<?php

namespace pizzashop\shop\domain\service\utils;

use Illuminate\Database\Capsule\Manager as DB;

class Eloquent
{
    public static function init($filename)
    {
        $test=realpath("../config/$filename");
        $db = new DB();
        $db->addConnection(parse_ini_file($test));
        $db->setAsGlobal();
        $db->bootEloquent();

    }
}