<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

class ThreeDSecure extends ApiResource
{
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    const OBJECT_NAME = "three_d_secure";
    public static function classUrl()
    {
        return "/v1/3d_secure";
    }
}

?>