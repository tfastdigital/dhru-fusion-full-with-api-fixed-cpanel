<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "../lib/nusoap.php";
require_once "../lib/class.wsdlcache.php";
$proxyhost = isset($_POST["proxyhost"]) ? $_POST["proxyhost"] : "";
$proxyport = isset($_POST["proxyport"]) ? $_POST["proxyport"] : "";
$proxyusername = isset($_POST["proxyusername"]) ? $_POST["proxyusername"] : "";
$proxypassword = isset($_POST["proxypassword"]) ? $_POST["proxypassword"] : "";
$useCURL = isset($_POST["usecurl"]) ? $_POST["usecurl"] : "0";
$login = "WSDEMO_01145";
$password = "DckHXMMHj";
$wsdlurl = "http://www.viamichelin.com/ws/services/Geocoding?wsdl";
$cache = new wsdlcache(".", 120);
$wsdl = $cache->get($wsdlurl);
if (is_null($wsdl)) {
    $wsdl = new wsdl($wsdlurl, $proxyhost, $proxyport, $proxyusername, $proxypassword, 0, 30, NULL, $useCURL);
    $err = $wsdl->getError();
    if ($err) {
        echo "<h2>WSDL Constructor error</h2><pre>" . $err . "</pre>";
        echo "<h2>Debug</h2><pre>" . htmlspecialchars($wsdl->getDebug(), ENT_QUOTES) . "</pre>";
        exit;
    }
    $cache->put($wsdl);
} else {
    $wsdl->debug_str = "";
    $wsdl->debug("Retrieved from cache");
}
$client = new nusoap_client($wsdl, "wsdl", $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
    echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->getDebug(), ENT_QUOTES) . "</pre>";
    exit;
}
$inputAddresses[] = ["address" => "45 Liberty Blvd.", "cityName" => "Malvern", "countryCode" => "USA", "postalCode" => "19355", "stateName" => "PA"];
$geocodingrequest = ["addressesList" => $inputAddresses];
$params = ["request" => $geocodingrequest, "check" => $login . "|" . $password];
$result = $client->call("getLocationsList", $params);
if ($client->fault) {
    echo "<h2>Fault (Expect - AUTHENTIFICATION)</h2><pre>";
    print_r($result);
    echo "</pre>";
} else {
    $err = $client->getError();
    if ($err) {
        echo "<h2>Error</h2><pre>" . $err . "</pre>";
    } else {
        echo "<h2>Result</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
}
echo "<h2>Request</h2><pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2><pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->getDebug(), ENT_QUOTES) . "</pre>";

?>