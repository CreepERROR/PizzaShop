<?php

namespace pizzashop\auth\api\domain\DTO\userDTOValidate;


class userValidateDTO  {
    
    private $accessToken;

    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken() {
        return $this->accessToken;
    }
}