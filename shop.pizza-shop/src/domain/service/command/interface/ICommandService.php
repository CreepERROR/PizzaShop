<?php

namespace pizzashop\shop\domain\service\command\interface;

interface ICommandService
{
    public function getCommandById(string $idCommand );
    public function readCommand(string $id);
    public function validateCommand(string $id);
    public function createCommand(string $mail,int $type, int $id, string $size,int $quantity);
}