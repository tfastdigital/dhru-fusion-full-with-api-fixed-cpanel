<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["htcunlockingname"] = "htcunlocking";
$APIMODULE["htcunlockingvisiblename"] = "htcunlocking.net";
$APIMODULE["htcunlockingnotes"] = "htcunlocking.net api";
function htcunlocking_activate()
{
    GatewayField("htcunlocking", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("htcunlocking", "System", "apiurl", "http://htcunlocking.net/api/", "APi url", "500", "");
}
function htcunlocking_services($VAL)
{
    $send["key"] = $VAL["apikey"];
    $send["imei"] = $VAL["IMEI"];
    $request = initCurl($VAL["apiurl"] . "//get-tools", $send);
    $request = json_decode($request, true);
    $return["Group"][0]["ID"] = "htcunlocking";
    $return["Group"][0]["Name"] = "htcunlocking.net";
    if ($request["out"]["tools"]) {
        foreach ($request["out"]["tools"] as $k => $v) {
            $return["Group"][0]["Tool"][$v["id"]]["ID"] = $v["id"];
            $return["Group"][0]["Tool"][$v["id"]]["Name"] = $v["name"];
        }
    }
    return $return;
}
function htcunlocking_send($VAL)
{
    global $debug_output;
    $send["key"] = $VAL["apikey"];
    $send["imei"] = $VAL["IMEI"];
    $send["tool_id"] = $VAL["API_ID"];
    $request = initCurl($VAL["apiurl"] . "//place-order", $send);
    $request = json_decode($request, true);
    if ($debug_output) {
        print_r($request);
    }
    if ($request["errno"] == "0") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "IMEI SENT TO htcunlocking.com";
        $return["ID"] = $request["out"]["ticket"];
    } else {
        $return["ERROR"] = nl2br($request["error"]);
        $return["MESSAGE"] = "Invalid field options ";
    }
    unset($send);
    unset($request);
    return $return;
}
function htcunlocking_get($VAL)
{
    global $debug_output;
    $send["key"] = $VAL["apikey"];
    $send["ticket"] = $VAL["API_ORDER_ID"];
    $request = initCurl($VAL["apiurl"] . "/get-order", $send);
    $request = json_decode($request, true);
    if ($debug_output) {
        print_r($request);
    }
    if ($request["errno"] == "0") {
        if ($request["out"]["status"] == "Failed") {
            $return["ERROR"] = $request["out"]["reason"];
            $return["MESSAGE"] = $request["out"]["reason"];
        }
        if ($request["out"]["codes"]) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars($request["out"]["codes"][0]["code"]);
            $return["CODES"] = htmlspecialchars($request["out"]["codes"][0]["code"]);
        }
    }
    return $return;
}

?>