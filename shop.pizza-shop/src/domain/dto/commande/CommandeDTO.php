<?php

namespace pizzashop\shop\domain\dto\commande;

class CommandeDTO
{

    public string $mail_client;
    public int $type_livraison;
    public array $itemDTO;

    /**
     * @param string $mail_client
     * @param int $type_livraison
     * @param array $itemDTO
     */
    public function __construct(string $mail_client, int $type_livraison, array $itemDTO)
    {
        $this->mail_client = $mail_client;
        $this->type_livraison = $type_livraison;
        $this->itemDTO = $itemDTO;
    }

    public function getItems()
    {
        return $this->itemDTO;
    }

}