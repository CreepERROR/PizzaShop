<?php

namespace pizzashop\shop\domain\service\Interface;

interface ICommandeService
{
    public function getCommandeById(string $idCommande );
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(string $mail,int $type, int $id, string $size,int $quantity);
}