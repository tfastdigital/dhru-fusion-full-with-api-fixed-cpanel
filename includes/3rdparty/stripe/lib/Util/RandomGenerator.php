<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Stripe\Util;

/**
 * A basic random generator. This is in a separate class so we the generator
 * can be injected as a dependency and replaced with a mock in tests.
 */
class RandomGenerator
{
    public function randFloat($max = 0)
    {
        return mt_rand() / mt_getrandmax() * $max;
    }
    public function uuid()
    {
        $arr = array_values(unpack("N1a/n4b/N1c", openssl_random_pseudo_bytes(16)));
        $arr[2] = $arr[2] & 4095 | 16384;
        $arr[3] = $arr[3] & 16383 | 32768;
        return vsprintf("%08x-%04x-%04x-%04x-%04x%08x", $arr);
    }
}

?>