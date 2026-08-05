<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once "../lib/nusoap.php";
$proxyhost = isset($_POST["proxyhost"]) ? $_POST["proxyhost"] : "";
$proxyport = isset($_POST["proxyport"]) ? $_POST["proxyport"] : "";
$proxyusername = isset($_POST["proxyusername"]) ? $_POST["proxyusername"] : "";
$proxypassword = isset($_POST["proxypassword"]) ? $_POST["proxypassword"] : "";
$client = new soapclient("https://arcweb.esri.com/services/v2/AddressFinder", false, $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
}
$result = $client->call("getVersion", [], "http://arcweb.esri.com/v2", "getVersion");
if ($client->fault) {
    echo "<h2>Fault</h2><pre>";
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
echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";

?>