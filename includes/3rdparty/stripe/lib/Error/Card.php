<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Error;

class Card extends Base
{
    public function __construct($message, $stripeParam, $stripeCode, $httpStatus, $httpBody, $jsonBody, $httpHeaders = NULL)
    {
        parent::__construct($message, $httpStatus, $httpBody, $jsonBody, $httpHeaders);
        $this->stripeParam = $stripeParam;
        $this->stripeCode = $stripeCode;
        $this->declineCode = isset($jsonBody["error"]["decline_code"]) ? $jsonBody["error"]["decline_code"] : NULL;
    }
    public function getDeclineCode()
    {
        return $this->declineCode;
    }
    public function getStripeParam()
    {
        return $this->stripeParam;
    }
}

?>