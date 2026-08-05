<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

class Webhook
{
    const DEFAULT_TOLERANCE = 300;
    public static function constructEvent($payload, $sigHeader, $secret, $tolerance = self::DEFAULT_TOLERANCE)
    {
        $data = json_decode($payload, true);
        $jsonError = json_last_error();
        if ($data === NULL && $jsonError !== JSON_ERROR_NONE) {
            $msg = "Invalid payload: " . $payload . " " . "(json_last_error() was " . $jsonError . ")";
            throw new \UnexpectedValueException($msg);
        }
        $event = Event::constructFrom($data);
        WebhookSignature::verifyHeader($payload, $sigHeader, $secret, $tolerance);
        return $event;
    }
}

?>