<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["eftpservername"] = "eftp-server.com";
$APIMODULE["eftpservervisiblename"] = "eftp-server.com";
$APIMODULE["eftpservernotes"] = "";
function eftpserver_activate()
{
    GatewayField("eftpserver", "text", "token", "", "Token", "500", "");
    GatewayField("eftpserver", "text", "api_sign", "", "APi Sign", "500", "");
}
function eftpserver_services($VAL)
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
    $return["Group"][0]["ID"] = "eftpserver";
    $return["Group"][0]["Name"] = "eftpserver ";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["ID"] = 1;
    $return["Group"][0]["Tool"][0]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["Name"] = "eftp-server.com activation - 1 year";
    $return["Group"][0]["Tool"][0]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    return $return;
}
function eftpserver_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $token = $VAL["token"];
    $api_sign = $VAL["api_sign"];
    $RECEIVER_USERNAME_OR_EMAIL = $customfields["Username"];
    $signature = md5($api_sign . sha1($RECEIVER_USERNAME_OR_EMAIL . "activate" . "1" . $token . $api_sign));
    $apiURL = "https://eftp-server.com/api_user?email=" . $RECEIVER_USERNAME_OR_EMAIL . "&operation=activate&y=1&token=" . $token . "&sign=" . $signature;
    $request = initCurlApi($apiURL);
    if ($request == "Success" || $request == "success") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $request;
        $return["CODES"] = "Activation Complete!";
    } else {
        $return["ERROR"] = nl2br($request);
        $return["MESSAGE"] = nl2br($request);
    }
    unset($send);
    unset($request);
    return $return;
}

?>