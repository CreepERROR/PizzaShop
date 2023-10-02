<?php

namespace Catalog;


use PHPUnit\Framework\TestCase;
use pizzashop\shop\domain\service\command\CommandService;
use pizzashop\shop\domain\service\catalog\CatalogService;
use Illuminate\Database\Capsule\Manager as DB;


class Test extends TestCase
{

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbcom = __DIR__ . '/../../config/commande.db.ini.template';
        $dbcat = __DIR__ . '/../../config/catalog.db.ini.template';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbcom), 'command');
        $db->addConnection(parse_ini_file($dbcat), 'catalog');
        $db->setAsGlobal();
        $db->bootEloquent();

//        self::$serviceProduits = new \pizzashop\shop\domain\service\catalog\CatalogService();
//        self::$serviceCommande = new \pizzashop\shop\domain\service\command\CommandService(self::$serviceProduits);
//        self::$faker = Factory::create('fr_FR');
//        self::fill();

    }

   public function testGetInformations(){
       $numero = '1';
       $taille = 1;
       $catlogService = new CatalogService();
       $produitDTO = $catlogService->getInformations($numero, $taille);
        // $this->assertEquals($numero, $produitDTO->getNumero());
   }

}
