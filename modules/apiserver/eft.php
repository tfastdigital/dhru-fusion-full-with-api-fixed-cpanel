<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["eftname"] = "eft";
$APIMODULE["eftvisiblename"] = "EFT Dongle ";
$APIMODULE["eftnotes"] = "EFT Dongle [dongle.sumatools.com]";
function eft_activate()
{
    GatewayField("eft", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("eft", "text", "apisecret", "", "APi SECRET", "500", "");
}
function eft_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Serial No";
    $__CustomFields[description] = "LicenseKey/Serial to Renew";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][0]["ID"] = "EFT Dongle";
    $return["Group"][0]["Name"] = "EFT Dongle";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["ID"] = 2;
    $return["Group"][0]["Tool"][0]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["Name"] = "EFT Dongle 1 Year Support Activation";
    $return["Group"][0]["Tool"][0]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    $return["Group"][0]["Tool"][1]["ID"] = 3;
    $return["Group"][0]["Tool"][1]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][1]["Name"] = "EFT Dongle 2 Year Support Activation";
    $return["Group"][0]["Tool"][1]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][1]["Credits"] = "1";
    return $return;
}
function eft_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $apikey = $VAL["apikey"];
    $apisecret = $VAL["apisecret"];
    $plan_id = $VAL["API_ID"];
    $rid = "12";
    $licenseKey = $customfields["Serial No"];
    $apiURL = "https://dongle.sumatools.com/api/v1/account/";
    $postData = ["a" => "expired", "b" => "renew", "api_key" => $apikey, "rid" => $rid, "license_key" => $licenseKey, "plan_id" => $plan_id, "post_token" => md5(rand(1, 500) . time())];
    ksort($postData);
    $signature = "";
    foreach ($postData as $key => $val) {
        if (is_string($val) || is_numeric($val)) {
            $signature .= $val;
        }
    }
    $signature = html_entity_decode(urldecode($signature));
    $postData["signature"] = md5($apisecret . $signature);
    $request = initCurl($apiURL, $postData);
    $request = json_decode($request, true);
    if ($request["type"] == "success") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $request["msg"];
        $return["CODES"] = "License key is renewal successful";
    } else {
        $return["ERROR"] = nl2br($request["msg"]);
        $return["MESSAGE"] = nl2br($request["msg"]);
    }
    unset($send);
    unset($request);
    return $return;
}

?>