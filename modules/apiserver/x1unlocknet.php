<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["x1unlocknetname"] = "x1unlocknet";
$APIMODULE["x1unlocknetvisiblename"] = "x1unlock.net (HTC NEW) ";
$APIMODULE["x1unlocknetnotes"] = "This x1unlock.net api";
function x1unlocknet_activate()
{
    GatewayField("x1unlocknet", "text", "apikey", "", "APi KEY", "100", "");
}
function x1unlocknet_accoutinfo($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlocknet.class.php";
    $api = new HTC_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function x1unlocknet_services($VAL)
{
    $return["Group"][0]["ID"] = "HTC_NEW";
    $return["Group"][0]["Name"] = "HTC NEW DB";
    $return["Group"][0]["Tool"]["HTC_NEW"]["ID"] = "HTC_NEW";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Name"] = "HTC NEW DB";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Message"] = "HTC NEW";
    $return["Group"][0]["Tool"]["HTC_NEW"]["Credits"] = "1";
    return $return;
}
function x1unlocknet_send($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlocknet.class.php";
    $api = new HTC_API();
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
function x1unlocknet_get($VAL)
{
    define("HTC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/x1unlocknet.class.php";
    $api = new HTC_API();
    $api->sendCommand("IMEI_LIST", ["id" => $VAL["API_ORDER_ID"]]);
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