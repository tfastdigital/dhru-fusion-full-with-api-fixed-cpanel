<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["x1unlockcomname"] = "x1unlockcom";
$APIMODULE["x1unlockcomvisiblename"] = "x1unlock.com (HTC OLD) ";
$APIMODULE["x1unlockcomnotes"] = "This x1unlock.com api";
function x1unlockcom_activate()
{
    GatewayField("x1unlockcom", "text", "apikey", "", "APi KEY", "100", "");
}
function x1unlockcom_accoutinfo($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlockcom.class.php";
    $api = new HTC_API_OLD();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function x1unlockcom_services($VAL)
{
    $return["Group"][0]["ID"] = "HTC_OLD";
    $return["Group"][0]["Name"] = "HTC OLD DB";
    $return["Group"][0]["Tool"]["HTC_NEW"]["ID"] = "HTC_OLD";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Name"] = "HTC OLD DB";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Message"] = "HTC OLD";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Credits"] = "1";
    return $return;
}
function x1unlockcom_send($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlockcom.class.php";
    $api = new HTC_API_OLD();
    $api->sendCommand("IMEI_SUBMIT", ["imei" => $VAL["IMEI"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["ID"]) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Send Success";
            $return["ID"] = $response["IMEI1"]["ID"];
        }
    }
    return $return;
}
function x1unlockcom_get($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlockcom.class.php";
    $api = new HTC_API_OLD();
    $api->sendCommand("IMEI_LIST", ["id" => $VAL["API_ORDER_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["STATUS"] == "Avail") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = $response["IMEI1"]["UNLOCK_CODE"];
        } else {
            if ($response["IMEI1"]["STATUS"] == "Not Avail") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>