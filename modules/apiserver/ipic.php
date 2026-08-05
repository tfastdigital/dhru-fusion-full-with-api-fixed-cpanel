<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["ipicname"] = "ipic";
$APIMODULE["ipicvisiblename"] = "iPic (iPhone info)";
$APIMODULE["ipicnotes"] = "iPic api  <br/> ** setup separate cron jobs by each api server and add this \"&sendlimitperround=15\" after this api cron command . <br/> **who have hosting on bluehost need to ask them to unblock PORT : 128 for out going connection . ";
function ipic_activate()
{
    GatewayField("ipic", "text", "apikey", "", "APi KEY", "100", "");
    GatewayField("ipic", "text", "server", "iphonecheck.dyndns.info", "Url/IP", "100", "");
    GatewayField("ipic", "text", "port", "128", "PORT", "100", "");
}
function ipic_accoutinfo($VAL)
{
    $imei = "1";
    $fp = fsockopen($VAL["server"], $VAL["port"], $errno, $errstr);
    if (!$fp) {
        echo "An error occured while trying to connect to the remote server.";
        exit;
    }
    $out = "check_credits key=" . $VAL["apikey"];
    fwrite($fp, $out);
    $data = fread($fp, 100);
    fclose($fp);
    if (deregi("not valid", $data)) {
        echo $data;
        exit;
    }
    $return["Credits available"] = $data;
    return $return;
}
function ipic_services($VAL)
{
    $return["Group"][0]["ID"] = "ipic";
    $return["Group"][0]["Name"] = "ipic";
    $return["Group"][0]["Tool"]["HTC_NEW"]["ID"] = "ipic";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Name"] = "ipic";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Message"] = "ipic";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Credits"] = "1";
    return $return;
}
function ipic_send($VAL)
{
    $fp = fsockopen($VAL["server"], $VAL["port"], $errno, $errstr);
    if ($fp) {
        $out = "imei=" . $VAL["IMEI"] . " key=" . $VAL["apikey"];
        fwrite($fp, $out);
        $data = fread($fp, 300);
        if ($data == "Checking...") {
            $data = fread($fp, 400);
        }
        fclose($fp);
    }
    if ($data) {
        if (deregi("Part Description", $data)) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["ID"] = $VAL["IMEI"];
            $return["CODES"] = nl2br($data);
        } else {
            $return["ERROR"] = nl2br($data);
            $return["MESSAGE"] = nl2br($data);
        }
    }
    unset($data);
    return $return;
}
function ipic_get_($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/ipic.class.php";
    $api = new HTCSUP_API();
    $api->sendCommand("IMEI_STATUS", ["id" => $VAL["API_ORDER_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["STATUS"] == "1") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = $response["IMEI1"]["UNLOCK_CODE"];
        } else {
            if ($response["IMEI1"]["STATUS"] == "2") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>