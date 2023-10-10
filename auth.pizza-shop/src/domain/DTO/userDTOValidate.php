<?php

namespace pizzashop\auth\api\domain\DTO\userDTOValidate;

class userValidateDTO extends pizzashop\auth\api\domain\DTO\DTO{

    private $accessToken;

    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken() {
        return $this->accessToken;
    }

    
}
