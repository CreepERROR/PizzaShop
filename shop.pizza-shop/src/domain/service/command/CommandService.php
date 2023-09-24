<?php

namespace pizzashop\shop\domain\service\command;

use Exception;

use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use pizzashop\shop\domain\service\command\interface\ICommandService;
use pizzashop\shop\models\Command;

class CommandService extends Exception implements ICommandService
{
    /**
     * Exemple d'utilisation des logs
     */
//        $log = new Logger('ServiceCommand');
//        $log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/Command/logService.log', Level::Info));
//        $log->pushHandler(new FirePHPHandler());
//        $log->info('ServiceCommande : constructeur');
//

    public function getCommandById(string $idCommande)
    {
        return Command::findOrFail($idCommande)->toArray();
    }
    public function validateCommand(string $id)
    {
        return Command::get($id)->where('id')->get();
    }
    public function readCommand(string $id)
    {
        return Command::findOrFail($id)->toArray();
    }

    public function createCommand(string $mail, int $type, int $id, string $size, int $quantity)
    {

    }
}






