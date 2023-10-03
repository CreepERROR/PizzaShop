<?php

namespace pizzashop\shop\domain\service\exception;

class CommandeNotFoundException extends \Exception
{
    // Exception code
    protected $code = 404;

    // Exception message

    protected $message = "Commande not found";

    // Constructor

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        if ($message) {
            $this->message = $message;
        }

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code, $previous);
    }

    // String representation of the exception

    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}