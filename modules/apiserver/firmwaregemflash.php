<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["firmwaregemflashname"] = "firmwaregemflash";
$APIMODULE["firmwaregemflashvisiblename"] = "firmware.gem-flash.com";
$APIMODULE["firmwaregemflashnotes"] = "firmware.gem-flash.com";
function firmwaregemflash_activate()
{
    GatewayField("firmwaregemflash", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("firmwaregemflash", "text", "apisecret", "", "APi SECRET", "500", "");
    GatewayField("firmwaregemflash", "text", "username", "", "Username OR eMail", "500", "");
    GatewayField("firmwaregemflash", "text", "password", "", "Password", "500", "");
}
function firmwaregemflash_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Username";
    $__CustomFields[description] = "You Username Or eMail";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][0]["ID"] = "firmwaregemflash";
    $return["Group"][0]["Name"] = "firmwaregemflash ";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["ID"] = 1;
    $return["Group"][0]["Tool"][0]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["Name"] = "firmware.gem-flash.com Balance Transfer";
    $return["Group"][0]["Tool"][0]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    $return["Group"][0]["Tool"][0]["QNT"] = "1";
    return $return;
}
function firmwaregemflash_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $apiKey = $VAL["apikey"];
    $apisecret = $VAL["apisecret"];
    $username = $VAL["username"];
    $password = $VAL["password"];
    $amount = $VAL["QNT"];
    $RECEIVER_USERNAME_OR_EMAIL = $customfields["Username"];
    $apiURL = "https://firmware.gem-flash.com/api/v1/";
    $postData = ["a" => "account", "b" => "balance_transfer", "userdata" => ["username" => $username, "secret" => md5($username . md5($password))], "transfer" => ["to" => $RECEIVER_USERNAME_OR_EMAIL, "amount" => $amount], "api_key" => $apiKey, "post_token" => md5(rand(1, 500) . time())];
    ksort($postData);
    $signature = "";
    foreach ($postData as $key => $val) {
        if (is_string($val) || is_numeric($val)) {
            $signature .= $val;
        }
    }
    $signature = html_entity_decode(urldecode($signature));
    $postData["signature"] = md5($apisecret . $signature);
    $request = initCurlApi($apiURL, $postData);
    $request = json_decode($request, true);
    if ($request["type"] == "success") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $request["msg"];
        $return["CODES"] = "Balance Transfer Done";
    } else {
        $return["ERROR"] = nl2br($request["msg"]);
        $return["MESSAGE"] = nl2br($request["msg"]);
    }
    unset($send);
    unset($request);
    return $return;
}

?>