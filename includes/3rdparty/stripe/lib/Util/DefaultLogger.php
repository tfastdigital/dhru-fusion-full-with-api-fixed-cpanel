<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

/**
 * A very basic implementation of LoggerInterface that has just enough
 * functionality that it can be the default for this library.
 */
class DefaultLogger implements LoggerInterface
{
    public function error($message, $context = [])
    {
        if (0 < count($context)) {
            throw new \Exception("DefaultLogger does not currently implement context. Please implement if you need it.");
        }
        error_log($message);
    }
}

?>