<?php

namespace Catalog;


use PHPUnit\Framework\TestCase;
use pizzashop\shop\domain\service\command\CommandService;

class Test extends TestCase
{

    public function test(){
        $commandService = new CommandService();
        $z = $commandService->readCommand("112e7ee1-3e8d-37d6-89cf-be3318ad6368");
        echo $z;
    }

}
