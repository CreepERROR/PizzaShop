<?php

namespace pizzashop\shop\domain\service\catalog;

use Exception;
use models\Catalog;
use models\Product;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\service\Catalog\Interface\ICatalogService;
use pizzashop\tests\catalog\ServiceCatalogTest;

use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CatalogService extends Exception implements ICatalogService
{

  public function readCatalog(CommandeDTO $CommandeDTO)
  {

  }

  public function validateCommand(string $id)
  {

  }

  public function createCommand(CommandeDTO $CommandeDTO)
  {
    // TODO: Implement createCommand() method.
  }

    public function readCommand(string $id)
    {
        // TODO: Implement readCommand() method.
    }
}