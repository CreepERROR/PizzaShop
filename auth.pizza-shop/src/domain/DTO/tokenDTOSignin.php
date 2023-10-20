<?php

namespace pizzashop\auth\api\domain\DTO;

class tokenDTOsignin{

    public $entete;
    public $payload;

    public function __construct($secret,$entete,$payload)
    {
        $this->entete = $entete;
        $this->payload = $payload;
    }
}

