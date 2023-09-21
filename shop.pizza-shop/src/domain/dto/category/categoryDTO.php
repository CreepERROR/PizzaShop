<?php

namespace pizzashop\shop\domain\dto\category;

class categoryDTO
{

    public int $id;
    /**
     * @var array liste des catégories
     */
    public array $itemDTO;

    /**
     * @param int $id
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