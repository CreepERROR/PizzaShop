<?php

namespace pizzashop\shop\domain\service\catalog;

use Exception;
use models\Catalog;
use models\Product;
use pizzashop\shop\domain\dto\catalogue\ProduitDTO;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\Catalog\Interface\ICatalogService;
use pizzashop\shop\models\Category;
use pizzashop\tests\catalog\ServiceCatalogTest;

use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CatalogService extends Exception implements ICatalogService
{

    /**
     * Retourne le catalogue complet
     * @return array
     */
  public function readCatalog()
  {
    // jsp si y a toutes les infos
    $catalog = Product::all()->toArray();
    return $catalog;
  }

  /**
   * Retourne le catalogue d'une catégorie
   * @param string $id
   * @return array
   */
  public function readCatalogByCategory(string $id)
  {
      // ici jsp si il faut faire un DTO
      $products = Product::where('categorie_id', '=', $id)->get()->toArray();
      return $products;
  }

  /**
   * Retourne les infos d'1 produit
   * @param string $id
   * @return ProduitDTO
   */
  public function getProduct(string $id, int $taille)
  {
    // TODO: Implement getProduct() method.
      $product = Product::where('id', '=', $id)->where('taille_id', '=', $taille)->first()->toArray();
      // si $product contient la categorie et la taille, on peut créer le DTO
      $DTOproduit = new ProduitDTO($product['numero'], $product['libelle'], $product['categorie'], $product['taille'], $product['tarif']);
      return $DTOproduit;
  }

}