<?php

namespace pizzashop\shop\domain\service\command\interface;

use pizzashop\shop\domain\dto\commande\CommandeDTO;

interface ICommandService
{
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(CommandeDTO $commandeDTO);
}