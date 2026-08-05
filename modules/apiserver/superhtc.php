<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["superhtcname"] = "superhtc";
$APIMODULE["superhtcvisiblename"] = "superhtc.net (Super HTC) ";
$APIMODULE["superhtcnotes"] = "This superhtc.net api";
function superhtc_activate()
{
    GatewayField("superhtc", "text", "apikey", "", "APi KEY", "100", "");
}
function superhtc_accoutinfo($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc.class.php";
    $api = new HTCSUP_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function superhtc_services($VAL)
{
    $return["Group"][0]["ID"] = "SUP_HTC";
    $return["Group"][0]["Name"] = "SUP_HTC";
    $return["Group"][0]["Tool"]["HTC_NEW"]["ID"] = "SUP_HTC";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Name"] = "SUP_HTC";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Message"] = "SUP_HTC";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Credits"] = "1";
    return $return;
}
function superhtc_send($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc.class.php";
    $api = new HTCSUP_API();
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
function superhtc_get($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc.class.php";
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