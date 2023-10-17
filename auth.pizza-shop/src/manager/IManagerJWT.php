<?php

interface IManagerJWT
{
    public function createToken($data);
    public function validateToken($token);
}