<?php

namespace pizzashop\shop\domain\service;

use Exception;
use models\Commande;

use pizzashop\shop\domain\service\Interface\ICommandeService;
use pizzashop\tests\commande\ServiceCommandeTest;



use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
/*
Interface de base
*/

class CommandService extends Exception implements ICommandeService
{
    /**
     * Exemple d'utilisation des logs
     */
//        $log = new Logger('ServiceCommande');
//        $log->pushHandler(new StreamHandler(__DIR__ . '/../../../logs/Commande/logService.log', Level::Info));
//        $log->pushHandler(new FirePHPHandler());
//        $log->info('ServiceCommande : constructeur');
//

    public function getCommandeById(string $idCommande)
    {
        return Commande::findOrFail($idCommande)->toArray();
    }
    public function validateCommand(string $id)
    {
        // TODO: Implement validateCommand() method.
    }

    public function createCommand(string $mail, int $type, int $id, string $size, int $quantity)
    {
        // TODO: Implement createCommand() method.
    }



    public function readCommand(string $id)
    {
        // TODO: Implement readCommand() method.
    }
}






