<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["bbcodesname"] = "bbcodes";
$APIMODULE["bbcodesvisiblename"] = "bbcodes.net (New BB CDMA Server)";
$APIMODULE["bbcodesnotes"] = "This bbcodes api";
function bbcodes_activate()
{
    GatewayField("bbcodes", "text", "apikey", "", "APi KEY", "100", "");
}
function bbcodes_accoutinfo($VAL)
{
    define("BBC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/bbcodes.class.php";
    $api = new BBC_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = "Credits available : " . $result["CREDITS"];
    return $return;
}
function bbcodes_services($VAL)
{
    $return["Group"][0]["ID"] = "BBCODES";
    $return["Group"][0]["Name"] = "New BB CDMA";
    $return["Group"][0]["Tool"]["BBCODES"]["ID"] = "BBCODES";
    $return["Group"][0]["Tool"]["BBCODES"]["Name"] = "New BB CDMA";
    $return["Group"][0]["Tool"]["BBCODES"]["Message"] = "18-MEID";
    $return["Group"][0]["Tool"]["BBCODES"]["Credits"] = "1";
    return $return;
}
function bbcodes_send($VAL)
{
    define("BBC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/bbcodes.class.php";
    $api = new BBC_API();
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
function bbcodes_get($VAL)
{
    define("BBC_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/bbcodes.class.php";
    $api = new BBC_API();
    $api->sendCommand("IMEI_STATUS", ["id" => $VAL["API_ORDER_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["ITEM1"]) {
        if ($response["ITEM1"]["STATUS"] == "1") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = $response["ITEM1"]["CODE"];
        } else {
            if ($response["ITEM1"]["STATUS"] == "2") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>