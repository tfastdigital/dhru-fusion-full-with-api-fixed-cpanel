<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["lgtoolname"] = "lgtool";
$APIMODULE["lgtoolvisiblename"] = "lgtool.org";
$APIMODULE["lgtoolnotes"] = "This lgtool.org api";
function lgtool_activate()
{
    GatewayField("lgtool", "text", "apikey", "", "APi KEY", "100", "");
}
function lgtool_accoutinfo($VAL)
{
    define("LGT_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/lgtool.class.php";
    $api = new LGT_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = "Credits available : " . $result["CREDITS"];
    return $return;
}
function lgtool_services($VAL)
{
    $return["Group"][0]["ID"] = "LgTool";
    $return["Group"][0]["Name"] = "Lg Tool";
    $return["Group"][0]["Tool"]["LgTool"]["ID"] = "LgTool";
    $return["Group"][0]["Tool"]["LgTool"]["Name"] = "Lg Tool";
    $return["Group"][0]["Tool"]["LgTool"]["Credits"] = "1";
    return $return;
}
function lgtool_send($VAL)
{
    define("LGT_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/lgtool.class.php";
    $api = new LGT_API();
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
function lgtool_get($VAL)
{
    define("LGT_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/lgtool.class.php";
    $api = new LGT_API();
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