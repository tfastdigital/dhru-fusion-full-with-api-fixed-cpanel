<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Mustache syntax exception.
 */
class Mustache_Exception_SyntaxException extends LogicException implements Mustache_Exception
{
    protected $token = NULL;
    public function __construct($msg, $token, Exception $previous = NULL)
    {
        $this->token = $token;
        if (version_compare(PHP_VERSION, "5.3.0", ">=")) {
            parent::__construct($msg, 0, $previous);
        } else {
            parent::__construct($msg);
        }
    }
    public function getToken()
    {
        return $this->token;
    }
}

?>