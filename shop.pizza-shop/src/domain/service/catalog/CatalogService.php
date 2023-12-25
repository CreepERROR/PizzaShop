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
      $product = Product::select('produit.*', 'tarif.tarif', 'categorie.libelle as categorie_libelle')
          ->join('tarif', 'produit.id', '=', 'tarif.produit_id')
          ->join('categorie', 'produit.categorie_id', '=', 'categorie.id')
          ->where('produit.numero', $num)
          ->first()->toArray();
        return $product;
  }

    /**
     * Retourne la liste des produits, il s'agit d'une liste complète
     * avec des informations minimales sur chaque produit, étendue avec une référence (URI) vers
     * le produit concerné permettant d'obtenir le détail du produit
     * @return void
     */
    public function getProducts()
    {
        return Product::select('produit.id', 'produit.libelle', 'produit.description', 'produit.image', 'categorie.libelle')
            ->join('categorie', 'produit.categorie_id', '=', 'categorie.id')
            ->get()->toArray();

    }

    public function getProduct($idProduct)
    {
        $produit = Product::select('produit.id', 'produit.libelle', 'produit.description', 'produit.image', 'categorie.libelle')
            ->join('tarif', 'produit.id', '=', 'tarif.produit_id')
            ->join('categorie', 'produit.categorie_id', '=', 'categorie.id')
            ->where('produit.id', $idProduct)
            ->first()->toArray();
        $tarifs = Product::select('taille.libelle as taille', 'tarif.tarif as tarif')
            ->join('tarif', 'produit.id', '=', 'tarif.produit_id')
            ->join('taille', 'tarif.taille_id', '=', 'taille.id')
            ->where('produit.id', $idProduct)
            ->get()->toArray();
        $produit['tarifs'] = $tarifs;
        return $produit;
    }
    public function getProductsByCategory($idCategorie){
        return Product::select('produit.id', 'produit.libelle', 'produit.description', 'produit.image', 'categorie.libelle')
            ->join('categorie', 'produit.categorie_id', '=', 'categorie.id')
            ->where('produit.categorie_id', $idCategorie)
            ->get()->toArray();
    }



}