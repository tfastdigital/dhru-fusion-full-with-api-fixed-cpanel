<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class ApplePayDomain
 *
 * @package Stripe
 */
class ApplePayDomain extends ApiResource
{
    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Delete;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "apple_pay_domain";
    public static function classUrl()
    {
        return "/v1/apple_pay/domains";
    }
}

?>