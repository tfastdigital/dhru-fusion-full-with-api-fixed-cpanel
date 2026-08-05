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
$GATEWAY = loadGatewayModule("ccavenue");
if (!$GATEWAY["merchantid"]) {
    exit("Not activated yet...");
}
if ($_POST) {
    $Order_Id = $_POST["Order_Id"];
    $WorkingKey = $GATEWAY["workingkey"];
    $Amount = $_POST["Amount"];
    $AuthDesc = $_POST["AuthDesc"];
    $Checksum = $_POST["Checksum"];
    $Merchant_Id = $_POST["Merchant_Id"];
    $signup = $_POST["Merchant_Param"];
    $Checksum = ccavenue_verifychecksum($Merchant_Id, $Order_Id, $Amount, $AuthDesc, $Checksum, $WorkingKey);
    $Order_Id = explode("_", $Order_Id);
    $Order_Id = $Order_Id[0];
    $Order_Id = checkCbInvoiceID($Order_Id, "CCAvenue");
    if ($Checksum == "true" && $AuthDesc == "Y") {
        addPayment($Order_Id, $_POST["Order_Id"], "", "", "ccavenue");
        logTransaction("ccavenue", $_REQUEST, "Successful");
        exit;
    }
    logTransaction("CCAvenue", $_REQUEST, "Error");
}
exit;
function ccavenue_verifychecksum($MerchantId, $OrderId, $Amount, $AuthDesc, $CheckSum, $WorkingKey)
{
    $str = $MerchantId . "|" . $OrderId . "|" . $Amount . "|" . $AuthDesc . "|" . $WorkingKey;
    $adler = 1;
    $adler = ccavenuecb_adler32($adler, $str);
    if ($adler == $CheckSum) {
        return "true";
    }
    return "false";
}
function ccavenuecb_adler32($adler, $str)
{
    $BASE = 65521;
    $s1 = $adler & 65535;
    $s2 = $adler >> 16 & 65535;
    for ($i = 0; $i < strlen($str); $i++) {
        $s1 = ($s1 + Ord($str[$i])) % $BASE;
        $s2 = ($s2 + $s1) % $BASE;
    }
    return ccavenuecb_leftshift($s2, 16) + $s1;
}
function ccavenuecb_leftshift($str, $num)
{
    $str = DecBin($str);
    for ($i = 0; $i < 64 - strlen($str); $i++) {
        $str = "0" . $str;
    }
    for ($i = 0; $i < $num; $i++) {
        $str = $str . "0";
        $str = substr($str, 1);
    }
    return ccavenuecb_cdec($str);
}
function ccavenuecb_cdec($num)
{
    for ($n = 0; $n < strlen($num); $n++) {
        $temp = $num[$n];
        $dec = $dec + $temp * pow(2, strlen($num) - $n - 1);
    }
    return $dec;
}

?>