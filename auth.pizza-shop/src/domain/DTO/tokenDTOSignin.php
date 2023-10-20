<?php

namespace pizzashop\auth\api\domain\DTO\tokenDTOsignin;

class tokenSigninDTO{

    private $secret;
    private $entete;
    private $payload;

    public function __construct($secret,$entete,$payload)
    {
        $this->secret = $secret;
        $this->entete = $entete;
        $this->payload = $payload;
    }
}

