<?php

namespace pizzashop\shop\domain\dto\category;

class categoryDTO
{

    public int $id;
    /* @param array libelé dto */
    public array $itemDTO;

    /**
     * @param string $mail_client
     * @param int $type_livraison
     * @param array $itemDTO
     */
    public function __construct(int $id, array $itemDTO)
    {
        $this->id = $id;
        $this->itemDTO = $itemDTO;
    }

    public function getID()
    {
        return $this->id;
    }

}