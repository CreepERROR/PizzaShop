<?php

namespace pizzashop\shop\domain\dto\commande;

class commandDTO extends \pizzashop\shop\domain\dto\DTO
 {

    public string $mail;
    public int $delivery_type;
    public float $total_cost;
    public int $state;
    public string $id;
    public string $date;



public function __construct(string $mail,int $delivery_type,float $total_cost,int $state,string $id,string $date)
{
    $this->mail = $mail;
    $this->delivery_type= $delivery_type;
    $this->total_cost= $total_cost;
    $this->state=$state;
    $this->id=$id;
    $this->date=$date;
}

}
?>