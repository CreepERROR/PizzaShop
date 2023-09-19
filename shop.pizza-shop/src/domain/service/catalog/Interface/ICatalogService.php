<?php

namespace pizzashop\shop\domain\service\catalog\Interface;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
interface ICatalogService
{
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(CommandeDTO $CommandeDTO);
}