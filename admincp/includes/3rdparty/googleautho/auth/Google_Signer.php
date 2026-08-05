<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "Google_P12Signer.php";
/**
 * Signs data.
 *
 * @author Brian Eaton <beaton@google.com>
 */
abstract class Google_Signer
{
    public abstract function sign($data);
}

?>