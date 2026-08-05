<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Error;

class Base extends \Exception
{
    public function __construct($message, $httpStatus = NULL, $httpBody = NULL, $jsonBody = NULL, $httpHeaders = NULL)
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->httpBody = $httpBody;
        $this->jsonBody = $jsonBody;
        $this->httpHeaders = $httpHeaders;
        $this->requestId = NULL;
        $this->stripeCode = isset($jsonBody["error"]["code"]) ? $jsonBody["error"]["code"] : NULL;
        if ($httpHeaders && isset($httpHeaders["Request-Id"])) {
            $this->requestId = $httpHeaders["Request-Id"];
        }
    }
    public function getStripeCode()
    {
        return $this->stripeCode;
    }
    public function getHttpStatus()
    {
        return $this->httpStatus;
    }
    public function getHttpBody()
    {
        return $this->httpBody;
    }
    public function getJsonBody()
    {
        return $this->jsonBody;
    }
    public function getHttpHeaders()
    {
        return $this->httpHeaders;
    }
    public function getRequestId()
    {
        return $this->requestId;
    }
    public function __toString()
    {
        $id = $this->requestId ? " from API request '" . $this->requestId . "'" : "";
        $message = explode("\n", parent::__toString());
        $message[0] .= $id;
        return implode("\n", $message);
    }
}

?>