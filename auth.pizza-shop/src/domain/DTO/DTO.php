<?php

namespace pizzashop\auth\api\domain\DTO;

abstract class DTO
{

    public function toJSON(): string {
        return json_encode($this, JSON_PRETTY_PRINT);
    }

}