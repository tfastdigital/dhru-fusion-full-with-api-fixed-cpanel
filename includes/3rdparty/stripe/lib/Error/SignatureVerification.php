<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Error;

class SignatureVerification extends Base
{
    public function __construct($message, $sigHeader, $httpBody = NULL)
    {
        parent::__construct($message, NULL, $httpBody, NULL, NULL);
        $this->sigHeader = $sigHeader;
    }
    public function getSigHeader()
    {
        return $this->sigHeader;
    }
}

?>