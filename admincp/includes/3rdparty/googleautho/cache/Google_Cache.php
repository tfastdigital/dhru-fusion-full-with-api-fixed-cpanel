<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Google_FileCache.php";
require_once "Google_MemcacheCache.php";
/**
 * Abstract storage class
 *
 * @author Chris Chabot <chabotc@google.com>
 */
abstract class Google_Cache
{
    public abstract function get($key, $expiration);
    public abstract function set($key, $value);
    public abstract function delete($key);
}

?>