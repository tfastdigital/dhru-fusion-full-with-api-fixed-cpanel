<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["ufiboxname"] = "ufibox";
$APIMODULE["ufiboxvisiblename"] = "ufibox.com";
$APIMODULE["ufiboxnotes"] = "";
function ufibox_activate()
{
    GatewayField("ufibox", "text", "username", "", "Username", "500", "");
    GatewayField("ufibox", "text", "password", "", "Password", "500", "");
}
function ufibox_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "ACCOUNTID";
    $__CustomFields[description] = "Account ID";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][1]["ID"] = "ufibox";
    $return["Group"][1]["Name"] = "ufibox";
    $return["Group"][1]["GroupType"] = "SERVER";
    $toolID = 1;
    $return["Group"][1]["Tool"][$toolID]["ID"] = "Transfer Credit";
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "Transfer Credit to Account ID";
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
    return $return;
}
function ufibox_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $username = $VAL["username"];
    $password = $VAL["password"];
    $credit = $VAL["QNT"];
    $_ACCOUNTID = filter_var($customfields["ACCOUNTID"], FILTER_SANITIZE_STRING);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://account.ufibox.com/c/login.php");
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36");
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIESESSION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, "j_ufi.txt");
    curl_setopt($ch, CURLOPT_COOKIEFILE, "c_ufi.txt");
    $answer = curl_exec($ch);
    $_Token_login = extractStringdd2($answer, "window.csrf = {token:\"", "\"};\n</script>");
    curl_setopt($ch, CURLOPT_URL, "https://account.ufibox.com/c/index.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "user_email=" . $username . "&user_password=" . $password . "&cmd=account/login&csrf_token=" . $_Token_login);
    $answer = curl_exec($ch);
    curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_error($ch)) {
        $return["ERROR"] = "CreditprocessError";
        $return["MESSAGE"] = curl_error($ch);
        return $return;
    }
    if (stripos($answer, "invalid") !== false) {
        if (stripos($answer, "invalid user email or password") !== false) {
            $_err = "Authentication Failed";
            $_errmsg = "Authentication Failed";
        } else {
            if (stripos($answer, "invalid token") !== false) {
                return NULL;
            }
            $_err = "CreditprocessError";
            $_errmsg = "Unknown error";
        }
        $return["ERROR"] = $_err;
        $return["MESSAGE"] = $_errmsg;
        return $return;
    }
    if (stripos($answer, "Logged in") !== false) {
        curl_setopt($ch, CURLOPT_URL, "https://account.ufibox.com/c/resellers.php?d=credit");
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "");
        $answer = curl_exec($ch);
        $_Token2 = extractStringdd2($answer, "window.csrf = {token:\"", "\"};let ufiapp");
        if ($_Token2) {
            curl_setopt($ch, CURLOPT_URL, "https://account.ufibox.com/c/index.php");
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "account_id=" . $_ACCOUNTID . "&balance=" . $credit . "&cmd=reseller/transfer_credit&csrf_token=" . $_Token2);
            $answer = curl_exec($ch);
            if (stripos($answer, "Invalid") !== false && stripos($answer, "Invalid user account") !== false) {
                $return["ERROR"] = "user account not valid";
                $return["MESSAGE"] = "user account not valid";
                return $return;
            }
            if (stripos($answer, "successfully") !== false) {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = "credit added successfully";
                $return["CODES"] = "credit added successfully";
                return $return;
            }
            return NULL;
        }
        return NULL;
    }
    $_err = "CreditprocessError";
    $_errmsg = "Unknown error";
    $return["ERROR"] = $_err;
    $return["MESSAGE"] = $_errmsg;
    return $return;
}
function extractStringdd2($string, $start, $end)
{
    $string = " " . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) {
        return "";
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

?>