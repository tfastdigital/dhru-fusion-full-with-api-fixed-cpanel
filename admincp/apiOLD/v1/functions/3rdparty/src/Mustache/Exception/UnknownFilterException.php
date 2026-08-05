<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Unknown filter exception.
 */
class Mustache_Exception_UnknownFilterException extends UnexpectedValueException implements Mustache_Exception
{
    protected $filterName = NULL;
    public function __construct($filterName, Exception $previous = NULL)
    {
        $this->filterName = $filterName;
        $message = sprintf("Unknown filter: %s", $filterName);
        if (version_compare(PHP_VERSION, "5.3.0", ">=")) {
            parent::__construct($message, 0, $previous);
        } else {
            parent::__construct($message);
        }
    }
    public function getFilterName()
    {
        return $this->filterName;
    }
}

?>