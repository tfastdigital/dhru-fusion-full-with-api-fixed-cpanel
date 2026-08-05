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
$client = new nusoap_client("http://soap.amazon.com/schemas2/AmazonWebServices.wsdl", "wsdl", $proxyhost, $proxyport, $proxyusername, $proxypassword);
$err = $client->getError();
if ($err) {
    echo "<h2>Constructor error</h2><pre>" . $err . "</pre>";
    exit;
}
$client->setUseCurl($useCURL);
$proxy = $client->getProxy();
$param = ["browse_node" => 18, "page" => 1, "mode" => "books", "tag" => "melonfire-20", "type" => "lite", "devtag" => "Your dev tag"];
$result = $proxy->BrowseNodeSearchRequest($param);
if ($proxy->fault) {
    echo "<h2>Fault</h2><pre>";
    print_r($result);
    echo "</pre>";
} else {
    $err = $proxy->getError();
    if ($err) {
        echo "<h2>Error</h2><pre>" . $err . "</pre>";
    } else {
        echo "<h2>Result</h2><pre>";
        print_r($result);
        echo "</pre>";
    }
}
echo "<h2>Request</h2><pre>" . htmlspecialchars($proxy->request, ENT_QUOTES) . "</pre>";
echo "<h2>Response</h2><pre>" . htmlspecialchars($proxy->response, ENT_QUOTES) . "</pre>";
echo "<h2>Client Debug</h2><pre>" . htmlspecialchars($client->debug_str, ENT_QUOTES) . "</pre>";
echo "<h2>Proxy Debug</h2><pre>" . htmlspecialchars($proxy->debug_str, ENT_QUOTES) . "</pre>";

?>