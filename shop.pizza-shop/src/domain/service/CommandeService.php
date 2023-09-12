<?php

namespace pizzashop\shop\domain\service;

use Exception;
use pizzashop\tests\commande\ServiceCommandeTest;

class CommandeService extends Exception
{
    private string $id;
    private $date;
    private int $type;
    private float $totalPrice;
    private int $state;
    private string $mail;

    public function __construct(string $id, $date, int $type, float $totalPrice, int $state, string $mail)
    {
        $this->id = $id;
        $this->date = $date;
        $this->type = $type;
        $this->totalPrice = $totalPrice;
        $this->state = $state;
        $this->mail = $mail;
    }

    public function readCommand(string $id){
            if ($id =  true) {
                return $id;
            }
            else {
                throw new Exception(ServiceCommandNotFound());
            }
    }

    public function validateCommand(string $id){

    }
}