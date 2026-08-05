<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["octoplusboxname"] = "octoplusbox";
$APIMODULE["octoplusboxvisiblename"] = "octoplusbox.com";
$APIMODULE["octoplusboxnotes"] = "";
function octoplusbox_activate()
{
    GatewayField("octoplusbox", "text", "username", "", "Username", "500", "");
    GatewayField("octoplusbox", "text", "password", "", "Password", "500", "");
}
function octoplusbox_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "USERNAME";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][1]["ID"] = "octoplusbox";
    $return["Group"][1]["Name"] = "octoplusbox";
    $return["Group"][1]["GroupType"] = "SERVER";
    $toolID = 1;
    $return["Group"][1]["Tool"][$toolID]["ID"] = "New User";
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "New User";
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    $toolID = 2;
    $return["Group"][1]["Tool"][$toolID]["ID"] = "Existing User";
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "Existing User";
    $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    return $return;
}
function octoplusbox_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $username = $VAL["username"];
    $password = $VAL["password"];
    $credit = $VAL["QNT"];
    $_username = filter_var($customfields["USERNAME"], FILTER_SANITIZE_STRING);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://support.octoplusbox.com:81/control/login.php");
    curl_setopt($ch, CURLOPT_USERAGENT, "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $username . "&password=" . $password);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "j.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "c.txt");
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        $return["ERROR"] = "CreditprocessError";
        $return["MESSAGE"] = curl_error($ch);
        return $return;
    }
    if (stripos($answer, "Error") !== false) {
        if (stripos($answer, "Login failed") !== false) {
            $_err = "Authentication Failed";
            $_errmsg = "Authentication Failed";
        } else {
            $_err = "CreditprocessError";
            $_errmsg = "Unknown error";
        }
        $return["ERROR"] = $_err;
        $return["MESSAGE"] = $_errmsg;
        return $return;
    }
    if ($_username) {
        $userurl = "http://support.octoplusbox.com:81/control/move_credits.php";
        $code = $credit . " credit added to user " . $_username;
    } else {
        $_username = generateRandomStringOctUser();
        $_password = generateRandomStringOctUser();
        $userurl = "http://support.octoplusbox.com:81/control/create_user.php";
        $code = "Username:" . $_username . "<br /> Password:" . $_password . "<br /> credit: " . $credit;
    }
    curl_setopt($ch, CURLOPT_URL, $userurl);
    curl_setopt($ch, CURLOPT_USERAGENT, "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $_username . "&password=" . $_password . "&privileges=1&credits=" . $credit . "&email=&website=&phone=&ICQ=&MSN=&Sonork=&Yahoo=&Skype=");
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        $return["ERROR"] = "CreditprocessError";
        $return["MESSAGE"] = curl_error($ch);
        return $return;
    }
    if (stripos($answer, "Error") !== false) {
        if (stripos($answer, "not found") !== false) {
            $return["ERROR"] = "username " . $_username . " not found!";
            $return["MESSAGE"] = "username " . $_username . " not found!";
        } else {
            $return["ERROR"] = "CreditprocessError";
            $return["MESSAGE"] = "Unknown Error";
        }
    } else {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = "SUCCESS";
        $return["CODES"] = $code;
    }
    return $return;
}
function generateRandomStringOctUser($length = 10)
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