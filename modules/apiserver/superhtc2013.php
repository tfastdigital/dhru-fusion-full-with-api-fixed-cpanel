<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["superhtc2013name"] = "superhtc2013";
$APIMODULE["superhtc2013visiblename"] = "superhtc2013.net ";
$APIMODULE["superhtc2013notes"] = "This superhtc2013.net api";
function superhtc2013_activate()
{
    GatewayField("superhtc2013", "text", "apikey", "", "APi KEY", "100", "");
}
function superhtc2013_accoutinfo($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc2013.class.php";
    $api = new HTCSUP_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function superhtc2013_services($VAL)
{
    $return["Group"][0]["ID"] = "superhtc2013";
    $return["Group"][0]["Name"] = "superhtc2013";
    $return["Group"][0]["Tool"]["HTC_NEW"]["ID"] = "superhtc2013";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Name"] = "superhtc2013";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Message"] = "superhtc2013";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Credits"] = "1";
    return $return;
}
function superhtc2013_send($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc2013.class.php";
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
function superhtc2013_get($VAL)
{
    define("HTCSUP_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/superhtc2013.class.php";
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