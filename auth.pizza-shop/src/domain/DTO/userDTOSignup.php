<?php

namespace pizzashop\auth\api\domain\DTO\userDTOSignup;

class UserSignUpDTO extends pizzashop\auth\api\domain\DTO\DTO  {
    
    public string $firstName;
    public string $lastName;
    public string $email;
    private string $password;

    public function __construct($firstName, $lastName, $email, $password) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    public function returnProfile($firstName, $lastName, $email, $password){
        return [$firstName,$lastName, $email, $password];
    }

}

 