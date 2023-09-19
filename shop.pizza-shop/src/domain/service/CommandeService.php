<?php

namespace pizzashop\shop\domain\service;

use PDO;
use pizzashop\tests\commande\ServiceCommandeTest;

/*
Interface de base (exo1 & 2)
*/

interface IcommandeService {

  
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(string $mail,int $type, int $id, string $size,int $quantity);

}

class Commande implements IcommandeService
{

    /*
     PDO pour get les données de l'api et faire ressortir la commande, DTO?
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
    Validation de la commande par l'id, doit être remplacé par un DTO
    */
    public function validateCommand(string $id)
    {
        if ($id =  true) {
            return $id;
        }
    }

    /* Implémentation exo 2 maladroitement, remplacé par un DTO */

    public function createCommand(string $mail, int $delivery, int $id, string $size, int $quantity)
    {
        $db = new PDO('mysql:host=pizza-shop.commande.db;dbname=pizza_shop;charset=utf8','pizza_shop','pizza_shop');
        $stmt = $db->prepare("INSERT INTO commande (mail, livraison, id, taille, quantite)
        VALUES (:mail, :delivery, :id, :taille, :quantite)");
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':delivery', $delivery);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':taille', $size);
        $stmt->bindParam(':quantite', $quantity);
        $stmt->execute();
        $getCommandId = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        
    
}