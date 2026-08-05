<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class LoginLink
 *
 * @property string $object
 * @property int $created
 * @property string $url
 *
 * @package Stripe
 */
class LoginLink extends ApiResource
{
    const OBJECT_NAME = "login_link";
}

?>