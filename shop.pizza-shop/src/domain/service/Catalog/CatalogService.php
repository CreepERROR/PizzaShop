<?php

namespace pizzashop\shop\domain\service\Catalog;

use Exception;
use models\Catalog;

use pizzashop\shop\domain\service\Catalog\Interface\ICatalogService;
use pizzashop\tests\catalog\ServiceCatalogTest;

use Monolog\Handler\FirePHPHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CatalogService extends Exception implements ICatalogService
{
  public function readCommand(string $id)
  {

  }

  public function validateCommand(string $id)
  {

  }

  public function createCommand(CommandeDTO $CommandeDTO)
  {

  }
}