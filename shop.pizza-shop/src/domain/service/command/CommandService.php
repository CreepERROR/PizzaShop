<?php

namespace pizzashop\shop\domain\service\command;

use Exception;

use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\Catalog\CatalogService;
use pizzashop\shop\domain\service\catalog\Interface\ICatalogService;
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
        //$commande = Command::with('items')->find($id)->toArray();
        $commande = Command::where('id', '=', $id)->first();
        $items = $commande->items()->get()->toArray();
        $commande = $commande->toArray();
        $DTOCommande = new CommandeDTO($commande['mail_client'], $commande['type_livraison'],$items);
        return $DTOCommande;
    }

    public function createCommand(CommandeDTO $commandeDTO)
    {
        // interroge le service Catalogue pour obtenir des informations sur chaque produit commandé.
        // La commande est créée : un identifiant est créé, la date de commande est enregistrée, l'état initial
        // de la commande est CREE.
        // Le montant total de la commande est calculé.
        // Un objet de type CommandeDTO est retourné, incluant toutes les informations disponibles.
        //pour tout les itemsDTO dans le $commandeDto

        foreach ($commandeDTO->getItems() as $item)
        {
            $catalog = CommandeDTO::updateOrCreate(
                ['id' =>  request('id')],
                ['date' => request('date')],
                ['state'=> request('created_at')],
            );
            $catalog->items()->get()->toArray();
            $create = new CommandeDTO($item);
            return $create;
        }


    }
}






