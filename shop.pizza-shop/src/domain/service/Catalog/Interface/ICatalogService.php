<?php

namespace pizzashop\shop\domain\service\Catalog\Interface;

interface ICatalogService
{
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(CommandeDTO $CommandeDTO);
}