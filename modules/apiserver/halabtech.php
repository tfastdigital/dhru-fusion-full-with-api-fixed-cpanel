<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["halabtechname"] = "halabtech";
$APIMODULE["halabtechvisiblename"] = "halabtech.com";
$APIMODULE["halabtechnotes"] = "halabtech.com";
function halabtech_activate()
{
    GatewayField("halabtech", "text", "username", "", "Username OR eMail", "500", "");
    GatewayField("halabtech", "text", "password", "", "Password", "500", "");
    GatewayField("halabtech", "text", "apikey", "", "Api Key", "500", "");
    GatewayField("halabtech", "text", "apisecret", "", "Api Secret", "500", "");
}
function halabtech_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "eMail";
    $__CustomFields[description] = "Your registered eMail";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][0]["ID"] = "halabtech";
    $return["Group"][0]["Name"] = "halabtech ";
    $return["Group"][0]["GroupType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["ID"] = 1;
    $return["Group"][0]["Tool"][0]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][0]["Name"] = "halabtech Balance Transfer";
    $return["Group"][0]["Tool"][0]["Requires.Custom"] = $CustomFields;
    $return["Group"][0]["Tool"][0]["Credits"] = "1";
    $return["Group"][0]["Tool"][0]["QNT"] = "1";
    return $return;
}
function halabtech_send($VAL)
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
    $apiURL = "https://support.halabtech.com/api/v1/";
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
    $request_json = initCurlApi($apiURL, $postData);
    $request = json_decode($request_json, true);
    if (is_array($request)) {
        if ($request["type"] == "success") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = $request["msg"];
            $return["CODES"] = "Balance Transfer Done";
            return $return;
        }
        $return["ERROR"] = nl2br($request);
        $return["MESSAGE"] = nl2br($request["msg"]);
        return $return;
    }
}
function halabtech_send_web($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $username = $VAL["username"];
    $password = $VAL["password"];
    $credit = $VAL["QNT"];
    $_username = $customfields["eMail"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://support.halabtech.com/index.php?a=login");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $username . "&password=" . $password . "&op=login&dfp=2a694db353cfbdd4e9f13d6b1a014fd2");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "j_halabtech.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "c_halabtech.txt");
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        $return["ERROR"] = "CreditprocessError";
        $return["MESSAGE"] = curl_error($ch);
        return $return;
    }
    if (stripos($answer, "Invalid Username") !== false) {
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
        $userurl = "https://support.halabtech.com/index.php?a=account";
        $code = $credit . " credit added to user " . $_username;
    }
    curl_setopt($ch, CURLOPT_URL, $userurl);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/75.0.3770.100 Safari/537.36");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "email=" . $_username . "&amount=" . $credit . "&op=do_transfer");
    $answer = curl_exec($ch);
    if (curl_error($ch)) {
        $return["ERROR"] = "CreditprocessError";
        $return["MESSAGE"] = curl_error($ch);
        return $return;
    }
    if (stripos($answer, "Transfer Failed") !== false || stripos($answer, "Undefined") !== false) {
        if (stripos($answer, "Email is not a valid") !== false) {
            $return["ERROR"] = "Email is not a valid email address ";
            $return["MESSAGE"] = "Email is not a valid email address";
        } else {
            if (stripos($answer, "Undefined") !== false) {
                $return["ERROR"] = "Undefined or Unregistered Account";
                $return["MESSAGE"] = "Undefined or Unregistered Account";
            } else {
                if (stripos($answer, "transfer to yourself") !== false) {
                    $return["ERROR"] = "You cannot transfer to yourself";
                    $return["MESSAGE"] = "You cannot transfer to yourself";
                } else {
                    $return["ERROR"] = "CreditprocessError";
                    $return["MESSAGE"] = "Unknown Error";
                }
            }
        }
    } else {
        if (stripos($answer, "transfer successful") !== false) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "SUCCESS";
            $return["CODES"] = $code;
        } else {
            $return["ERROR"] = "CreditprocessError";
            $return["MESSAGE"] = "Unknown Error";
        }
    }
    return $return;
}

?>