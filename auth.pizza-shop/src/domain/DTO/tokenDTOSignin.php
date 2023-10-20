<?php

namespace pizzashop\auth\api\domain\DTO;

class tokenDTOsignin{

    private $secret;
    private $entete;
    private $payload;

    public function __construct($secret,$entete,$payload)
    {
        $this->entete = $entete;
        $this->payload = $payload;
    }
}

