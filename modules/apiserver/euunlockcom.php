<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["euunlockcomname"] = "euunlockcom";
$APIMODULE["euunlockcomvisiblename"] = "eu-unlock.com";
$APIMODULE["euunlockcomnotes"] = "This eu-unlock.com api";
function euunlockcom_activate()
{
    GatewayField("euunlockcom", "text", "apikey", "", "APi KEY", "100", "");
}
function euunlockcom_accoutinfo($VAL)
{
    define("euunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/euunlockcom.class.php";
    $api = new euunlockcom_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function euunlockcom_services($VAL)
{
    $return["Group"][0]["ID"] = "EU_UNLOCK";
    $return["Group"][0]["Name"] = "EU_UNLOCK";
    $return["Group"][0]["Tool"]["EU_UNLOCK"]["ID"] = "EU_UNLOCK";
    $return["Group"][0]["Tool"]["EU_UNLOCK"]["Name"] = "EU_UNLOCK";
    $return["Group"][0]["Tool"]["EU_UNLOCK"]["Message"] = "EU_UNLOCK";
    $return["Group"][0]["Tool"]["EU_UNLOCK"]["Credits"] = "1";
    return $return;
}
function euunlockcom_send($VAL)
{
    define("euunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/euunlockcom.class.php";
    $api = new euunlockcom_API();
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
function euunlockcom_get($VAL)
{
    define("euunlockcom_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/euunlockcom.class.php";
    $api = new euunlockcom_API();
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