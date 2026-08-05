<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\PseudoRandomString;

class McryptPseudoRandomStringGenerator implements PseudoRandomStringGeneratorInterface
{
    use PseudoRandomStringGeneratorTrait;
    const ERROR_MESSAGE = "Unable to generate a cryptographically secure pseudo-random string from mcrypt_create_iv(). ";
    public function __construct()
    {
        if (!function_exists("mcrypt_create_iv")) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "The function mcrypt_create_iv() does not exist.");
        }
    }
    public function getPseudoRandomString($length)
    {
        $this->validateLength($length);
        $binaryString = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
        if ($binaryString === false) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "mcrypt_create_iv() returned an error.");
        }
        return $this->binToHex($binaryString, $length);
    }
}

?>