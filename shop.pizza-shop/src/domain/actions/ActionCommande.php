<?php

namespace pizzashop\shop\domain\actions;

use pizzashop\shop\domain\service\CommandeService;

class ActionCommande implements IcommandeService
{

    /*
     PDO pour get les données de l'api et faire ressortir la commande
    */

    public function readCommand(string $id)
    {
//        $db = new PDO('mysql:host=pizza-shop.commande.db;dbname=pizza_shop;charset=utf8', 'pizza_shop', 'pizza_shop');
//        $getData = $db->prepare('SELECT * FROM command');
//        $getData->execute();
//        $getCommandId = $getData->fetchAll();

        $commandeService = new CommandeService();
        $commande = $commandeService->getCommandeById($id);
    }
//    public function readCommand(string $id){
//
//    }
//
//
//    /*
//    Validation de la commande par l'id
//    */
//    public function validateCommand(string $id)
//    {
//        if ($id =  true) {
//            return $id;
//        }
//    }
//
//    /* Implémentation exo 2 maladroitement */
//
//    public function createCommand(string $mail, int $delivery, int $id, string $size, int $quantity)
//    {
//        $db = new PDO('mysql:host=pizza-shop.commande.db;dbname=pizza_shop;charset=utf8','pizza_shop','pizza_shop');
//        $stmt = $db->prepare("INSERT INTO commande (mail, livraison, id, taille, quantite)
//        VALUES (:mail, :delivery, :id, :taille, :quantite)");
//        $stmt->bindParam(':mail', $mail);
//        $stmt->bindParam(':delivery', $delivery);
//        $stmt->bindParam(':id', $id);
//        $stmt->bindParam(':taille', $size);
//        $stmt->bindParam(':quantite', $quantity);
//        $stmt->execute();
//        $getCommandId = $stmt->fetchAll(PDO::FETCH_ASSOC);
//    }


}