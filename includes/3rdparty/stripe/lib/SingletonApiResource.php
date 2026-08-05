<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe;

/**
 * Class SingletonApiResource
 *
 * @package Stripe
 */
class SingletonApiResource extends ApiResource
{
    protected static function _singletonRetrieve($options = NULL)
    {
        $opts = Util\RequestOptions::parse($options);
        $instance = new static(NULL, $opts);
        $instance->refresh();
        return $instance;
    }
    public static function classUrl()
    {
        $base = str_replace(".", "/", static::OBJECT_NAME);
        return "/v1/" . $base;
    }
    public function instanceUrl()
    {
        return static::classUrl();
    }
}

?>