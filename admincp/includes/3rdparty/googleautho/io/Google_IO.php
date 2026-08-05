<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "io/Google_HttpRequest.php";
require_once "io/Google_CurlIO.php";
require_once "io/Google_REST.php";
/**
 * Abstract IO class
 *
 * @author Chris Chabot <chabotc@google.com>
 */
interface Google_IO
{
    public function authenticatedRequest(Google_HttpRequest $request);
    public function makeRequest(Google_HttpRequest $request);
    public function setOptions($options);
}

?>