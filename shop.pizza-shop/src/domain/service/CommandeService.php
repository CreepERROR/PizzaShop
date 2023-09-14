<?php

namespace pizzashop\shop\domain\service;

use PDO;
use pizzashop\tests\commande\ServiceCommandeTest;

/*
Interface de base
*/

interface IcommandeService {

  
    public function readCommand(string $id);
    public function validateCommand(string $id);

}

/* 
Peut être implémentation d'une interface ou classe pour les données
*/
// interface IdataType {
//     const $date = new \DateTime('now');
//     private int $type;
//     private float $totalPrice;
//     private int $state;
//     private string $mail;
// }

class Commande implements IcommandeService
{

    /*
     PDO pour get les données de l'api et faire ressortir la commande
    */

    public function readCommand(string $id)
    {
        $db = new PDO('mysql:host=pizza-shop.commande.db;dbname=pizza_shop;charset=utf8','pizza_shop','pizza_shop');
        $getData = $db->prepare('SELECT * FROM command');
        $getData->execute();
        $getCommandId = $getData->fetchAll();

        if ($getCommandId == $id){
            echo $id;
        }
    }


    /*
    Validation de la commande par l'id
    */
    public function validateCommand(string $id)
    {
        if ($id =  true) {
            return $id;
        }
    }
        
    
}