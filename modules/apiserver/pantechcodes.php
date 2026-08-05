<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["pantechcodesname"] = "pantechcodes";
$APIMODULE["pantechcodesvisiblename"] = "pantechcodes.com";
$APIMODULE["pantechcodesnotes"] = "This pantechcodes api";
function pantechcodes_activate()
{
    GatewayField("pantechcodes", "text", "apikey", "", "APi KEY", "100", "");
}
function pantechcodes_accoutinfo($VAL)
{
    define("PAN_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/pantechcodes.class.php";
    $api = new PAN_API();
    $api->sendCommand("GET_CREDITS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $api->checkError($resultArray["RESULT"]);
    $result = $resultArray["RESULT"];
    $return["Credits available"] = $result["CREDITS"];
    return $return;
}
function pantechcodes_services($VAL)
{
    $return["Group"][0]["ID"] = "pantechcodes";
    $return["Group"][0]["Name"] = "pantechcodes";
    $return["Group"][0]["Tool"]["BBCODES"]["ID"] = "pantechcodes";
    $return["Group"][0]["Tool"]["BBCODES"]["Name"] = "pantechcodes";
    $return["Group"][0]["Tool"]["BBCODES"]["Message"] = "pantechcodes unlcok service";
    $return["Group"][0]["Tool"]["BBCODES"]["Credits"] = "1";
    $return["Group"][0]["Tool"]["BBCODES"]["Requires.Mobile"] = "Required";
    return $return;
}
function pantechcodes_mobiles($VAL)
{
    define("PAN_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/pantechcodes.class.php";
    $api = new PAN_API();
    $api->sendCommand("GET_MODELS", []);
    $resultArray = $api->parse2Array($api->getResult());
    $resultArray["RESULT"];
    $return["Brand"][0]["Name"] = "Pantech";
    $return["Brand"][0]["ID"] = "00001";
    foreach ($resultArray["RESULT"] as $k => $v) {
        $return["Brand"][0]["Mobile"][$k]["ID"] = $v["MODEL_ID"];
        $return["Brand"][0]["Mobile"][$k]["Name"] = $v["MODEL_NAME"];
    }
    return $return;
}
function pantechcodes_assign_mobiles($VAL)
{
    define("PAN_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/pantechcodes.class.php";
    $api = new PAN_API();
    $api->sendCommand("GET_MODELS", []);
    $resultArray = $api->parse2Array($api->getResult());
    foreach ($resultArray["RESULT"] as $k => $v) {
        $Data[$k]["ID"] = $v["MODEL_ID"];
        $Data[$k]["Name"] = $v["MODEL_NAME"];
        $Data[$k]["Model"] = $v["MODEL_NAME"];
    }
    saveApiAssignMobiles($Data, $VAL["apiservers"], true, "00001");
    $Data = NULL;
}
function pantechcodes_send($VAL)
{
    define("PAN_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/pantechcodes.class.php";
    $api = new PAN_API();
    $api->sendCommand("IMEI_ORDER", ["imei" => $VAL["IMEI"], "model" => $VAL["API_MODEL_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["STATUS"] == "1") {
        if ($response["ID"]) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Send Success";
            $return["ID"] = $response["ID"];
        }
    }
    return $return;
}
function pantechcodes_get($VAL)
{
    define("PAN_API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/pantechcodes.class.php";
    $api = new PAN_API();
    $api->sendCommand("IMEI_LIST", ["id" => $VAL["API_ORDER_ID"]]);
    $resultArray = $api->parse2Array($api->getResult());
    $response = $resultArray["RESULT"];
    if ($response["IMEI1"]) {
        if ($response["IMEI1"]["STATUS"] == "2") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Code Found";
            $return["CODES"] = $response["IMEI1"]["UNLOCK_CODE"];
        }
    }
    return $return;
}

?>