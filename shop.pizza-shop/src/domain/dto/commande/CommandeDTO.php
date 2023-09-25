<?php

namespace pizzashop\shop\domain\dto\commande;

class CommandeDTO
{
    public string $id;
    public string $date_commande;
    public int $delai;
    public float $montant_total;
    public string $mail_client;
    public int $type_livraison;
    public array $itemDTO;

    public int $state = 1;

    /**
     * @param string $id
     * @param string $date_commande
     * @param float $montant_total
     * @param string $mail_client
     * @param int $type_livraison
     * @param array $itemDTO
     */
    public function __construct(string $id, $date_commande, $montant_total ,string $mail_client, int $type_livraison, array $itemDTO)
    {
        $this->mail_client = $mail_client;
        $this->type_livraison = $type_livraison;
        $this->itemDTO = $itemDTO;
        $this->id = $id;
        $this->date_commande = $date_commande;
        $this->montant_total = $montant_total;
    }

    public function getItems()
    {
        return $this->itemDTO;
    }

}