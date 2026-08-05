<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["usunlockcomname"] = "usunlockcom";
$APIMODULE["usunlockcomvisiblename"] = "us-unlock.com";
$APIMODULE["usunlockcomnotes"] = "This us-unlock.com api";
function usunlockcom_activate()
{
    GatewayField("usunlockcom", "text", "apikey", "", "APi KEY", "100", "");
}
function usunlockcom_accoutinfo($VAL)
{
    define("usunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/usunlockcom.class.php";
    $api = new usunlockcom_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function usunlockcom_services($VAL)
{
    $return["Group"][0]["ID"] = "US_UNLOCK";
    $return["Group"][0]["Name"] = "US_UNLOCK";
    $return["Group"][0]["Tool"]["US_UNLOCK"]["ID"] = "US_UNLOCK";
    $return["Group"][0]["Tool"]["US_UNLOCK"]["Name"] = "US_UNLOCK";
    $return["Group"][0]["Tool"]["US_UNLOCK"]["Message"] = "US_UNLOCK";
    $return["Group"][0]["Tool"]["US_UNLOCK"]["Credits"] = "1";
    return $return;
}
function usunlockcom_send($VAL)
{
    define("usunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/usunlockcom.class.php";
    $api = new usunlockcom_API();
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
function usunlockcom_get($VAL)
{
    define("usunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/usunlockcom.class.php";
    $api = new usunlockcom_API();
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