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
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator;

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
        $DTOCommande = new CommandeDTO($commande['mail_client'], $commande['type_livraison'], $items, $commande['id'], $commande['date_commande'], $commande['montant_total'], $commande['etat']);
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
        $montantTotal = 0;
        foreach ($commandeDTO->getItems() as $item) {
            $numero = $item['numero'];
            $taille = $item['taille'];
            $catalog = new CatalogService();
            $item = $catalog->getInformations($numero, $taille);
            $montantTotal += $item['prix'] * $item['quantite'];
        }

        $id = Uuid::uuid4();
            Command::create([
                'id' => $id,
                'date_commande' => date('Y-m-d H:i:s'),
                'montant_total' => $montantTotal,
                'etat' => 1,
                'mail_client' => $commandeDTO->mail_client,
                'type_livraison' => $commandeDTO->type_livraison,
            ]);
        return $this->readCommand($id);


    }

    /**
     * Vérif que les contraintes sont bien respectées
     * @param ValidatorInterface $validator
     * @param CommandeDTO $commandeDTO
     * @return Response
     */
    public function validateDataCommand(ValidatorInterface $validator, CommandeDTO $commandeDTO): Response
    {
        $errors = $validator->validate($commandeDTO);
        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

        return new Response('La commande est validée !!');
    }

}






