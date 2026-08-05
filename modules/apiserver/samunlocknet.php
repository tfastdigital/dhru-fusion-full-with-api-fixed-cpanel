<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samunlocknetname"] = "samunlocknet";
$APIMODULE["samunlocknetvisiblename"] = "Samunlock.net ** New sam tool **";
$APIMODULE["samunlocknetnotes"] = "";
function samunlocknet_activate()
{
    GatewayField("samunlocknet", "text", "username", "", "Username", "500", "");
    GatewayField("samunlocknet", "text", "password", "", "Password", "500", "");
}
function samunlocknet_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Username";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][0]["ID"] = "samunlocknet";
    $return["Group"][0]["Name"] = "samunlocknet";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][1]["ID"] = 1;
    $return["Group"][0]["Tool"][1]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][1]["Name"] = "samunlock.net credit to existing user";
    $return["Group"][0]["Tool"][1]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][1]["Credits"] = "1";
    $return["Group"][0]["Tool"][1]["QNT"] = "1";
    $return["Group"][0]["Tool"][2]["ID"] = 2;
    $return["Group"][0]["Tool"][2]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][2]["Name"] = "samunlocknet credit to new user";
    $return["Group"][0]["Tool"][2]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][2]["Credits"] = "1";
    $return["Group"][0]["Tool"][2]["QNT"] = "1";
    return $return;
}
function samunlocknet_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $postData["username"] = $VAL["username"];
    $postData["password"] = $VAL["password"];
    if ($VAL["API_ID"] == 1) {
        $action = "sendCredit";
        $postData["receiver"] = $customfields["Username"];
        $postData["credit"] = $VAL["QNT"];
    } else {
        if ($VAL["API_ID"] == 2) {
            $action = "addUser";
            $postData["newUsername"] = $customfields["Username"];
            $postData["newPassword"] = generateRandomStringsamunlocknet();
            $request = initCurl("http://manage.samunlock.net/api/" . $action, $postData);
            $request = json_decode($request, true);
            if ($request["status"] == "ok") {
                $action = "sendCredit";
                $postData["receiver"] = $customfields["Username"];
                $postData["credit"] = $VAL["QNT"];
                $request_og = initCurl("http://manage.samunlock.net/api/" . $action, $postData);
                $request = json_decode($request_og, true);
                if ($request["status"] == "ok" || strtolower($request["status"]) == strtolower("successful")) {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = json_encode($request);
                    $return["CODES"] = "Username : " . $customfields["Username"] . " <br /> Password : " . $postData["newPassword"] . " <br /> Credit : " . $VAL["QNT"];
                    return $return;
                }
                $return["ERROR"] = strip_tags($request_og);
                $return["MESSAGE"] = $request["status"];
                return $return;
            }
            $return["ERROR"] = json_encode($request);
            $return["MESSAGE"] = $request["status"];
            return $return;
        }
        if ($VAL["API_ID"] == 3) {
            $action = "activeUser";
            $postData["activeUser"] = $customfields["Username"];
            $request_og = initCurl("http://kingunlock.net/api/" . $action, $postData);
            $request = json_decode($request_og, true);
            if ($request["status"] == "ok") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = json_encode($request);
                $return["CODES"] = $customfields["Username"] . " activated successfully ";
                return $return;
            }
            $return["ERROR"] = strip_tags($request_og);
            $return["MESSAGE"] = $request["status"];
            return $return;
        }
    }
    $request_og = initCurl("http://manage.samunlock.net/api/" . $action, $postData);
    $request = json_decode($request_og, true);
    if ($request["status"] == "ok" || strtolower($request["status"]) == strtolower("successful")) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = json_encode($request);
        $return["CODES"] = $VAL["QNT"] . " Credit added successful to " . $customfields["Username"];
    } else {
        $return["ERROR"] = strip_tags($request_og);
        $return["MESSAGE"] = $request["status"];
    }
    unset($send);
    unset($request);
    return $return;
}
function generateRandomStringsamunlocknet($length = 10)
{
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

?>