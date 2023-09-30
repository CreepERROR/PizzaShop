<?php

namespace pizzashop\shop\domain\service\command;

use commande\ServiceCommandeTest as CommandeServiceCommandeTest;
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
     * Valide une commande en passant son état à VALIDE (2)
     * @param string $id
     * @return CommandeDTO|void
     */
    public function validateCommand(string $id)
    {
        $log = new Logger('ServiceCommand:validateCommand');
        try {
            $commande = Command::where('id', '=', $id);
            $commande->update(['etat' => 2]);
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Info));
            $log->pushHandler(new FirePHPHandler());
            $log->info('ValidateCommande: id = ' . $id . ' and state =' . $commande->etat);

        } catch (\Exception $e) {
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Error));
            $log->pushHandler(new FirePHPHandler());
            $log->error('invalidateCommand : ' . $e->getMessage());
            exit();
        }
        return $this->readCommand($id);
    }

    /**
     * Recherche une commande et ses items associés
     * @param string $id
     * @return CommandeDTO|void
     */
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
        $DTOCommande = new CommandeDTO($commande['id'], $commande['date_commande'], $commande['montant_total'], $commande['etat'], $commande['mail_client'], $commande['type_livraison'], $items);
        $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Info));
        $log->pushHandler(new FirePHPHandler());
        $log->info('id = ' . $id);

        return $DTOCommande;

    }
// Utilisé pour les test Uniquement

    /**
     * Tests uniquement, Invalide une commande en mettant son etat à 1.
     * @param string $id
     */
    public function invalidateCommande(string $id)
    {
        $log = new Logger('ServiceCommand:validateCommand');
        try {
            Command::where('id', '=', $id)->update(['etat' => 1]);
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Info));
            $log->pushHandler(new FirePHPHandler());
            $log->info('ValidateCommande: id = ' . $id);
        } catch (\Error $e) {
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Error));
            $log->pushHandler(new FirePHPHandler());
            $log->error('validateCommand : ' . $e->getMessage());
            exit();
        }
    }


    /**
     * Crée une commande dans la BDD
     * @param CommandeDTO $commandeDTO
     * @return CommandeDTO|void
     */
    public function createCommand(CommandeDTO $commandeDTO)
    {
        // paramètres = CommandeDTO avec mail client, type livraison, liste items commandés (numéro, taille, quantité).
        // interroge le service Catalogue pour obtenir des informations sur chaque produit commandé.
        // La commande est créée : un identifiant est créé, la date de commande est enregistrée, l'état initial
        // de la commande est CREE.
        // Le montant total de la commande est calculé.//
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

    // j'ai essayé de faire l'exo 4 avec la commande request et validate mais je suis vraiment pas sur d'ou le placer etc */
    /**
     * Vérifie si les données d'une commande sont valides
     * @param CommandeDTO $commandeDTO
     * @return CommandeDTO|void
     */
    public function validate(): CommandeDTO
    {
        $commandeDTO = new CommandeDTO($this->id, $this->date_commande, $this->type_livraison, $this->mail_client, $this->montant_total, $this->delai, []);
        foreach ($this->items as $item) {
            $commandeDTO->request()->validate([
                'email' => [],
                'etat' => ['1', '2', '3', '4'],
                'type de livraison' => ['1', '2', '3'],
                'item' => [$item],
            ]);

        }
    }

}






