<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["imeiunlocksname"] = "imeiunlocks";
$APIMODULE["imeiunlocksvisiblename"] = "imeiunlocks.net";
$APIMODULE["imeiunlocksnotes"] = "imeiunlocks.net api";
function imeiunlocks_activate()
{
    GatewayField("imeiunlocks", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("imeiunlocks", "System", "apiurl", "http://imeiunlocks.net/api/", "APi url", "500", "");
}
function imeiunlocks_services($VAL)
{
    $send["key"] = $VAL["apikey"];
    $send["imei"] = $VAL["IMEI"];
    $request = initCurl($VAL["apiurl"] . "//get-tools", $send);
    $request = json_decode($request, true);
    $return["Group"][0]["ID"] = "imeiunlocks";
    $return["Group"][0]["Name"] = "imeiunlocks.net";
    if ($request["out"]["tools"]) {
        foreach ($request["out"]["tools"] as $k => $v) {
            $return["Group"][0]["Tool"][$v["id"]]["ID"] = $v["id"];
            $return["Group"][0]["Tool"][$v["id"]]["Name"] = $v["name"];
        }
    }
    return $return;
}
function imeiunlocks_send($VAL)
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
        $return["MESSAGE"] = "IMEI SENT TO imeiunlocks.com";
        $return["ID"] = $request["out"]["ticket"];
    } else {
        $return["ERROR"] = nl2br($request["error"]);
        $return["MESSAGE"] = "Invalid field options ";
    }
    unset($send);
    unset($request);
    return $return;
}
function imeiunlocks_get($VAL)
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