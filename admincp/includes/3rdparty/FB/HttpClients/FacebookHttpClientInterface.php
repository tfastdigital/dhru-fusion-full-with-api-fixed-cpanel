<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace Facebook\HttpClients;

/**
 * Interface FacebookHttpClientInterface
 *
 * @package Facebook
 */
interface FacebookHttpClientInterface
{
    public function send($url, $method, $body, $headers, $timeOut);
}

?>