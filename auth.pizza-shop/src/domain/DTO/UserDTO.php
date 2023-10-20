<?php

namespace pizzashop\auth\api\domain\DTO;

class UserDTO {

    public string $username;
    public ?string $email;
    public ?string $password;
    public ?int $active;
    public ?string $activation_token;
    public ?string $activation_token_expiration_date;
    public ?string $refresh_token;
    public ?string $refresh_token_expiration_date;
    public ?string $reset_passwd_token;
    public ?string $reset_passwd_token_expiration_date;


    public function __construct(string $username, ?string $email=null, ?string $password=null, ?int $active=null, ?string $activation_token=null, ?string $activation_token_expiration_date=null, ?string $refresh_token=null, ?string $refresh_token_expiration_date=null, ?string $reset_passwd_token=null, ?string $reset_passwd_token_expiration_date=null)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->active = $active;
        $this->activation_token = $activation_token;
        $this->activation_token_expiration_date = $activation_token_expiration_date;
        $this->refresh_token = $refresh_token;
        $this->refresh_token_expiration_date = $refresh_token_expiration_date;
        $this->reset_passwd_token = $reset_passwd_token;
        $this->reset_passwd_token_expiration_date = $reset_passwd_token_expiration_date;
    }


}