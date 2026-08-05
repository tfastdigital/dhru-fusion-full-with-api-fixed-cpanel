<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Error;

class InvalidRequest extends Base
{
    public function __construct($message, $stripeParam, $httpStatus = NULL, $httpBody = NULL, $jsonBody = NULL, $httpHeaders = NULL)
    {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->stripeParam = $stripeParam;
    }
    public function getStripeParam()
    {
        return $this->stripeParam;
    }
}

?>