<?php

namespace pizzashop\shop\domain\service\catalog;

use Exception;
use pizzashop\shop\models\Product;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\service\Catalog\Interface\ICatalogService;
use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class CatalogService extends Exception implements ICatalogService
{

  /**
   * Retourne les infos d'1 produit pour CommandeService
   * @param string $id
   * @return ProduitDTO
   */
  public function getInformations(string $num, int $taille)
  {
      $product = Product::where('numero', '=', $num)->first()->toArray();
      echo $product;
  }

}