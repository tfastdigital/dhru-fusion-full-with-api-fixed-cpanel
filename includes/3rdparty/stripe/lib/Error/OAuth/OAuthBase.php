<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Error\OAuth;

class OAuthBase extends \Stripe\Error\Base
{
    public function __construct($code, $description, $httpStatus = NULL, $httpBody = NULL, $jsonBody = NULL, $httpHeaders = NULL)
    {
        parent::__construct($description, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->errorCode = $code;
    }
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}

?>