<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Unknown helper exception.
 */
class Mustache_Exception_UnknownHelperException extends InvalidArgumentException implements Mustache_Exception
{
    protected $helperName = NULL;
    public function __construct($helperName, Exception $previous = NULL)
    {
        $this->helperName = $helperName;
        $message = sprintf("Unknown helper: %s", $helperName);
        if (version_compare(PHP_VERSION, "5.3.0", ">=")) {
            parent::__construct($message, 0, $previous);
        } else {
            parent::__construct($message);
        }
    }
    public function getHelperName()
    {
        return $this->helperName;
    }
}

?>