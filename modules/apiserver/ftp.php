<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["ftpname"] = "ftp";
$APIMODULE["ftpvisiblename"] = "FTP Dongle ";
$APIMODULE["ftpnotes"] = "ftp Dongle [ftp-dongle.easy-firmware.com]";
function ftp_activate()
{
    GatewayField("ftp", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("ftp", "text", "apisecret", "", "APi SECRET", "500", "");
}
function ftp_services($VAL)
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
    $return["Group"][0]["ID"] = "ftp Dongle";
    $return["Group"][0]["Name"] = "ftp Dongle";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["ID"] = 1;
    $return["Group"][0]["Tool"][0]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["Name"] = "FTP Dongle 1 Year Activation";
    $return["Group"][0]["Tool"][0]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    return $return;
}
function ftp_send($VAL)
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
    $apiURL = "https://ftp-dongle.easy-firmware.com/api/v1/account/index.php";
    $postData = ["a" => "order", "b" => "make", "api_key" => trim($apikey), "license_key" => trim($licenseKey), "plan_id" => trim($plan_id), "post_token" => md5(rand(1, 500) . time())];
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