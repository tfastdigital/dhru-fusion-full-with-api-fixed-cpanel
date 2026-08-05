<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
include "../../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/gateway.fun.php";
include ROOTDIR . "/includes/invoice.fun.php";
$GATEWAY = loadGatewayModule("nochex");
if (!$GATEWAY["paymentmethod"]) {
    exit("Not activated yet....");
}
$debugreport = "";
if (!isset($_POST)) {
    $_POST =& $HTTP_POST_VARS;
}
foreach ($_POST as $key => $value) {
    $values[] = $key . "=" . urlencode($value);
    $debugreport .= $key . " => " . $value . chr(10);
}
$work_string = @implode("&", $values);
$url = "https://www.nochex.com/nochex.dll/apc/apc";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDSIZE, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, $work_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
curl_setopt($ch, CURLOPT_SSLVERSION, 3);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$output = curl_exec($ch);
curl_close($ch);
$response = preg_replace("'Content-type: text/plain'si", "", $output);
if ($response == "AUTHORISED") {
    addPayment($_POST["order_id"], $_POST["transaction_id"], "", "", "nochex");
    logTransaction("NoChex", $debugreport, "Successful");
    return 1;
}
logTransaction("NoChex", $debugreport, "Invalid");

?>