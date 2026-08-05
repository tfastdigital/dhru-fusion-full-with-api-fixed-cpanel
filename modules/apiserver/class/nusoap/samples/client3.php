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
$client = new nusoap_client("http://api.google.com/search/beta2", false, $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
    echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->getDebug(), ENT_QUOTES) . "</pre>";
    exit;
}
$client->setUseCurl($useCURL);
$client->soap_defencoding = "UTF-8";
$params = ["Googlekey" => "Your Google key", "queryStr" => "robotics", "startFrom" => 0, "maxResults" => 10, "filter" => true, "restrict" => "", "adultContent" => true, "language" => "", "iencoding" => "", "oendcoding" => ""];
$result = $client->call("doGoogleSearch", $params, "urn:GoogleSearch", "urn:GoogleSearch");
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
echo "<h2>Debug</h2><pre>" . htmlspecialchars($client->getDebug(), ENT_QUOTES) . "</pre>";

?>