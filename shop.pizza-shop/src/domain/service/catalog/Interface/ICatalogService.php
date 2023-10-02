<?php

namespace pizzashop\shop\domain\service\catalog\Interface;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
interface ICatalogService
{
    public function getInformations(string $num, int $taille);
}