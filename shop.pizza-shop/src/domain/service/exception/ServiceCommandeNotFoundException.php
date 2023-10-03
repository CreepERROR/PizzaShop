<?php

namespace pizzashop\shop\domain\service\exception;

class ServiceCommandeNotFoundException extends Exception {
    public function __construct($message = "Service de commande introuvable", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}