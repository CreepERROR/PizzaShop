<?php

namespace pizzashop\shop\domain\dto\price;

class priceDTO
{

    /* @param int des prix pour le dto */
    public int $product_id;
    public int $size_id;
    public int $price;
    

    
    public function __construct(int $product_id, int $size_id, int $price)
    {
        $this->product_id = $product_id;
        $this->size_id = $size_id;
        $this->price= $price;
    }

    public function getProductId()
    {
        return $this->product_id;
    }

}