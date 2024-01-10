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
use pizzashop\shop\models\Item;
use pizzashop\shop\models\Size;
use Ramsey\Uuid\Uuid;
use Respect\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use GuzzleHttp\Client;



class CommandService extends Exception implements ICommandService
{
    /**
     * Valide une commande en passant son état à VALIDE (2)
     * @param string $id
     * @return CommandeDTO|array
     */
    public function validateCommand(string $id)
    {
        $log = new Logger('ServiceCommand:validateCommand');
        try {
            $commande = Command::where('id', '=', $id);
            $commande->update(['etat' => 2]);
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Info));
            $log->pushHandler(new FirePHPHandler());
            //$log->info('ValidateCommande: id = ' . $id . ' and state =' . $commande->etat);
        } catch (\Exception $e) {
            $log->pushHandler(new StreamHandler(__DIR__ . '/../../../../logs/Command/logService.log', Level::Error));
            $log->pushHandler(new FirePHPHandler());
            $log->error('invalidateCommand : ' . $e->getMessage());
            exit();
        }
        $commande = [
            'etat' => 'validee',
            $this->readCommand($id)
        ];
        return $commande;
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
        $listeItems = [];
        $id = Uuid::uuid4()->toString();

        foreach ($commandeDTO->getItems() as $item) {
            $numero = $item['numero'];
            $quantite = $item['quantite'];
            $clientCat = new Client([
                'base_uri' => 'http://api.pizza-shop',
                'timeout' => 15.0,
                'headers' => [
                    'Accept' => 'application/json',
                    'Origin' => '*'
                ]
            ]);
            $responseCat = $clientCat->request('GET', '/produit/'.$numero);
            $codeCat = $responseCat->getStatusCode();
            if ($codeCat != 200) {
                throw new \Exception('Pas accès au produit');
            } else {
                $bodyRepCat = $responseCat->getBody()->getContents();
                $bodyRepCat = stripslashes(html_entity_decode($bodyRepCat));
                $bodyRepCat=json_decode($bodyRepCat,true);
                $id = $bodyRepCat['id'];
                $numero = $bodyRepCat['numero'];
                $libelle = $bodyRepCat['libelle'];
                foreach ($bodyRepCat['tarifs'] as $tarif) {
                    if ($tarif['taille_id'] == $item['taille']) {
                        $taille = $tarif['taille'];
                        $prix = $tarif['tarif'];
                    }
                }
            }

            //$catalog = new CatalogService();
            //$itemBdd = $catalog->getInformations($numero, $taille);
            $montantTotal += floatval($tarif) * $quantite;
            //$tailleBdd = Size::where('id', '=', $taille)->first()->toArray();

            // Ajoutez les informations de l'item au tableau $listeItems
            $listeItems[] = [
                'numero' => $numero,
                'libelle' => $libelle,
                'taille' => $taille,
                'tarif' => $prix,
                'quantite' => $quantite,
            ];

        }
            Command::updateOrCreate([
                'id' => $id,
                'delai'=>1,
                'date_commande' => date('Y-m-d H:i:s'),
                'montant_total' => $montantTotal,
                'etat' => 1,
                'mail_client' => $commandeDTO->mail_client,
                'type_livraison' => $commandeDTO->type_livraison,
            ]);
        $array = $listeItems;
        return new CommandeDTO($commandeDTO->mail_client, $commandeDTO->type_livraison, $array, $id, date('Y-m-d H:i:s'), $montantTotal, 1);

    }

    /**
     * Vérif que les contraintes sont bien respectées
     * @param ValidatorInterface $validator
     * @param CommandeDTO $commandeDTO
     * @return Response
     */
    public function validateDataCommand(ValidatorInterface $validator, CommandeDTO $commandeDTO) : Response
    {
        $allErrors = array();
        $violations = $validator->validate($commandeDTO->mail_client, [
            new Assert\Email(),
            new Assert\NotBlank(),
        ]);
        $allErrors[] = $violations;

        $violations = $validator->validate($commandeDTO->type_livraison, [
            new Assert\NotBlank(),
            new Assert\Type('integer'),
            new Assert\Range([
                'min' => 1,
                'max' => 3
            ])
        ]);
        $allErrors[] = $violations;

        $violations = $validator->validate($commandeDTO->itemDTO, [
            new Assert\NotBlank(),
            new Assert\Type('array'),
        ]);
        $allErrors[] = $violations;

        foreach ($commandeDTO->itemDTO as $item) {
            $violations = $validator->validate($item['numero'], [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Positive()
            ]);
            $allErrors[] = $violations;

            $violations = $validator->validate($item['quantite'], [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Positive()
            ]);
            $allErrors[] = $violations;

            $violations = $validator->validate($item['taille'], [
                new Assert\NotBlank(),
                new Assert\Type('integer'),
                new Assert\Range([
                    'min' => 1,
                    'max' => 2
                ])
            ]);
            $allErrors[] = $violations;
        }

        $allErrors = implode($allErrors);
        return new Response($allErrors);
    }

}






