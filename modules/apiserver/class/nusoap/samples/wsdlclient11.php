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
$useCURL = isset($_POST["usecurl"]) ? $_POST["usecurl"] : "0";
$client = new soapclient("http://www.scottnichol.com/samples/hellowsdl3.wsdl", true, $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
}
$client->setUseCurl($useCURL);
$person = ["firstname" => "Willi", "age" => 22, "gender" => "male"];
$name = ["name" => $person];
$result = $client->call("hello", $name);
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
echo "<h2>Request</h2>";
echo "<pre>" . htmlspecialchars($client->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2>";
echo "<pre>" . htmlspecialchars($client->response, ENT_QUOTES) . "</pre>";
echo "<h2>Debug</h2>";
echo "<pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";

?>