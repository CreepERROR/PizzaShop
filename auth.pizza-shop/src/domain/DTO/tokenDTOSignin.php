<?php

namespace pizzashop\auth\api\domain\DTO\tokenDTOsignin;

class tokenSigninDTO{

    private $entete;
    private $payload;

    public function __construct($secret,$entete,$payload)
    {
        $this->entete = $entete;
        $this->payload = $payload;
    }
}

