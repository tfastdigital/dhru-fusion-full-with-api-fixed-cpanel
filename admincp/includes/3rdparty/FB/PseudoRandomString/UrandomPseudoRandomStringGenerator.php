<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\PseudoRandomString;

class UrandomPseudoRandomStringGenerator implements PseudoRandomStringGeneratorInterface
{
    use PseudoRandomStringGeneratorTrait;
    const ERROR_MESSAGE = "Unable to generate a cryptographically secure pseudo-random string from /dev/urandom. ";
    public function __construct()
    {
        if (ini_get("open_basedir")) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "There is an open_basedir constraint that prevents access to /dev/urandom.");
        }
        if (!is_readable("/dev/urandom")) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "Unable to read from /dev/urandom.");
        }
    }
    public function getPseudoRandomString($length)
    {
        $this->validateLength($length);
        $stream = fopen("/dev/urandom", "rb");
        if (!is_resource($stream)) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "Unable to open stream to /dev/urandom.");
        }
        if (!defined("HHVM_VERSION")) {
            stream_set_read_buffer($stream, 0);
        }
        $binaryString = fread($stream, $length);
        fclose($stream);
        if (!$binaryString) {
            throw new \Facebook\Exceptions\FacebookSDKException(static::ERROR_MESSAGE . "Stream to /dev/urandom returned no data.");
        }
        return $this->binToHex($binaryString, $length);
    }
}

?>