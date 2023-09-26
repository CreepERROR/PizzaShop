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

//    function __construct()
//    {
//        $this->log = new Logger('ServiceCommand');
//        $this->log->pushHandler(new StreamHandler(__DIR__ . '../../../../logs/Command/logService.log', Level::Info));
//        $this->log->pushHandler(new FirePHPHandler());
//        $this->log->info('ServiceCommande : constructeur');
//    }
    public function validateCommand(string $id)
    {
        return Command::get($id)->where('id')->get();
    }

    public function readCommand(string $id)
    {
        $log = new Logger('ServiceCommand:readCommand');
        try {
            $commande = Command::where('id', '=', $id)->first();
        } catch (\Error $e) {
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Error));
            $log->pushHandler(new FirePHPHandler());
            $log->error('readCommand : ' . $e->getMessage());
            exit();
        }
        try {
            $items = $commande->items()->get()->toArray();
        } catch (\Error $e) {
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Error));
            $log->pushHandler(new FirePHPHandler());
            $log->error('readCommand : ' . $e->getMessage());
            exit();
        }
        $commande = $commande->toArray();
        $DTOCommande = new CommandeDTO($commande['id'], $commande['date_commande'], $commande['montant_total'],  $commande['mail_client'], $commande['type_livraison'], $items);

        $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Info));
        $log->pushHandler(new FirePHPHandler());
        $log->info('id = ' . $id);

        return $DTOCommande;

    }

    public function createCommand(CommandeDTO $commandeDTO)
    {
        // interroge le service Catalogue pour obtenir des informations sur chaque produit commandé.
        // La commande est créée : un identifiant est créé, la date de commande est enregistrée, l'état initial
        // de la commande est CREE.
        // Le montant total de la commande est calculé.//TODO
        // Un objet de type CommandeDTO est retourné, incluant toutes les informations disponibles.
        //pour tout les itemsDTO dans le $commandeDto

        foreach ($commandeDTO->getItems() as $item) {
            $catalog = CommandeDTO::updateOrCreate(
                ['id' => request('id')],
                ['date' => request('date')],
                ['state' => request('created_at')],
            );
            $catalog->items()->get()->toArray();
            $catalog = array_sum($catalog);
            $create = new CommandeDTO('id', 'date', $item);
            return $create;
        }


    }

    /* j'ai essayé de faire l'exo 4 avec la commande request et validate mais je suis vraiment pas sur d'ou le placer etc */
    public function validate(): CommandeDTO
    {
        $commandeDTO = new CommandeDTO($this->id, $this->date_commande, $this->type_livraison ,$this->mail_client, $this->montant_total, $this->delai, []);
        foreach ($this->items as $item) {
            $commandeDTO->request()->validate([
                'email'=> [],
                'etat'=>['1','2','3','4'],
                'type de livraison'=> ['1','2','3'],
                'item'=>[$item],
            ]);

        }
    }
}






