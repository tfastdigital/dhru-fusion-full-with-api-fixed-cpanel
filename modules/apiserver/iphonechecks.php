<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["iphonechecksname"] = "iPhoneChecks";
$APIMODULE["iphonechecksvisiblename"] = "iPhoneChecks.com";
$APIMODULE["iphonechecksnotes"] = "iPhoneChecks.com api";
function iphonechecks_activate()
{
    GatewayField("iphonechecks", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("iphonechecks", "System", "apiurl", "http://www.iphonechecks.com/api/", "APi url", "500", "");
}
function iphonechecks_services($VAL)
{
    $return["Group"][0]["ID"] = "iPhoneChecks";
    $return["Group"][0]["Name"] = "iPhoneChecks.com";
    $return["Group"][0]["Tool"][0]["ID"] = "1";
    $return["Group"][0]["Tool"][0]["Name"] = "iPhoneChecks";
    return $return;
}
function iphonechecks_send($VAL)
{
    $send["imei"] = $VAL["IMEI"];
    $send["key"] = trim($VAL["apikey"]);
    $send["tool_id"] = $VAL["API_ID"];
    $request = initCurl($VAL["apiurl"] . "/place-order", $send);
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "IMEI Sent to iphonechecks.com";
        $return["ID"] = $request["out"]["order_id"];
    } else {
        $return["ERROR"] = nl2br($request["error"]);
        $return["MESSAGE"] = "Invalid field options ";
    }
    unset($send);
    unset($request);
    return $return;
}
function iphonechecks_get($VAL)
{
    $send["order_id"] = $VAL["API_ORDER_ID"];
    $send["key"] = $VAL["apikey"];
    $request = initCurl($VAL["apiurl"] . "/get-order", $send);
    $request = json_decode($request, true);
    if ($request["errno"] == "0") {
        if ($request["out"]["status"] == "Delivered") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars($request["out"]["locked"]);
            $return["CODES"] = $request["out"]["result"];
        } else {
            if ($request["out"]["status"] == "Failed") {
                $return["ERROR"] = "Not Found";
                $return["MESSAGE"] = "Not Found";
            }
        }
    }
    return $return;
}

?>