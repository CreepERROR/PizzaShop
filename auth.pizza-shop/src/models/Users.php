<?php

namespace pizzashop\auth\api\models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    /*
     * email	varchar(128)
password	varchar(256)
active	tinyint(4) [0]
activation_token	varchar(64) NULL
activation_token_expiration_date	timestamp NULL
refresh_token	varchar(64) NULL
refresh_token_expiration_date	timestamp NULL
reset_passwd_token	varchar(64) NULL
reset_passwd_token_expiration_date	timestamp NULL
username	varchar(64) NULL
     */
    protected $connection = 'auth';
    protected $table = 'users';
    protected $primaryKey = 'email';
    public $timestamps = false;
    protected $fillable = ['email', 'password', 'active', 'activation_token', 'activation_token_expiration_date', 'refresh_token', 'refresh_token_expiration_date', 'reset_passwd_token', 'reset_passwd_token_expiration_date', 'username'];


}