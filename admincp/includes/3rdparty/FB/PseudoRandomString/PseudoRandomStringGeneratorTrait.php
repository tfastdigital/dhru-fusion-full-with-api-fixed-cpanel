<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\PseudoRandomString;

trait PseudoRandomStringGeneratorTrait
{
    public function validateLength($length)
    {
        if (!is_int($length)) {
            throw new \InvalidArgumentException("getPseudoRandomString() expects an integer for the string length");
        }
        if ($length < 1) {
            throw new \InvalidArgumentException("getPseudoRandomString() expects a length greater than 1");
        }
    }
    public function binToHex($binaryData, $length)
    {
        return mb_substr(bin2hex($binaryData), 0, $length);
    }
}

?>