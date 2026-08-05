<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("UFIC_API_PROJECT", "UFIC-API-Client/1.0");
define("UFIC_API_HOST", "https://account.ufibox.com/api");
$APIMODULE["ufiboxnewname"] = "ufiboxnew";
$APIMODULE["ufiboxnewvisiblename"] = "ufibox.com (New )";
$APIMODULE["ufiboxnewnotes"] = "";
function ufiboxnew_activate()
{
    GatewayField("ufiboxnew", "text", "email", "", "Email", "500", "");
    GatewayField("ufiboxnew", "text", "apikey", "", "APi Key", "500", "");
}
function ufiboxnew_accoutinfo($VAL)
{
    $post = NULL;
    $my_account = ["email" => $VAL["email"], "api_key" => $VAL["apikey"]];
    $d = apiCall("/auth", NULL, $my_account);
    $Response = json_decode($d, true);
    if ($Response["status"] == 200) {
        $server_key = $Response["data"]["token"];
        if (isset($server_key)) {
            $d = apiCall("/info", $server_key);
            $Response = json_decode(trim($d), true);
            $return["SUCCESS"] = "SUCCESS";
            $return["MESSAGE"] = json_encode($Response);
            return $return;
        }
        $return["ERROR"] = "Authorisaction error";
        $return["MESSAGE"] = $Response["data"]["message"];
        return $return;
    }
}
function ufiboxnew_services($VAL)
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
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "EMAIL";
    $__CustomFields[description] = "Email";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][1]["ID"] = "ufiboxnew";
    $return["Group"][1]["Name"] = "ufiboxnew";
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
function apiCall($path, $server_key = NULL, $payload = NULL)
{
    $optArray = [CURLOPT_URL => UFIC_API_HOST . $path, CURLOPT_CONNECTTIMEOUT => 5, CURLOPT_TIMEOUT => 10, CURLOPT_SSL_VERIFYHOST => false, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_RETURNTRANSFER => true, CURLOPT_FRESH_CONNECT => true];
    $ch = curl_init();
    curl_setopt_array($ch, $optArray);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $header = [];
    $header[] = "User-Agent: " . UFIC_API_PROJECT;
    $header[] = "Cache-Control: no-cache";
    if (isset($server_key)) {
        $header[] = "X-Token: " . $server_key;
    }
    curl_setopt($ch, CURLOPT_POST, true);
    if ($payload != NULL) {
        $post_data = base64_encode(json_encode($payload));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($ch);
    curl_close($ch);
    return trim($response);
}
function ufiboxnew_send($VAL)
{
    $my_account = ["email" => $VAL["email"], "api_key" => $VAL["apikey"]];
    $d = apicall("/auth", NULL, $my_account);
    $Response = json_decode($d, true);
    if ($Response["status"] == 200) {
        $server_key = $Response["data"]["token"];
        if (isset($server_key)) {
            $user = ["email" => $VAL["EMAIL"], "account_id" => $VAL["ACCOUNTID"], "balance" => 1];
            $d = apicall("/transfer", $server_key, $user);
            $Response = json_decode($d, true);
            if ($Response["status"] == 200) {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = $Response["data"]["message"];
                $return["CODES"] = $Response["data"]["message"];
                return $return;
            }
            $return["ERROR"] = "Error Status 2";
            $return["MESSAGE"] = $d;
            return $return;
        }
        $return["ERROR"] = "Error Status2";
        $return["MESSAGE"] = $Response["data"]["message"];
        return $return;
    }
    $return["ERROR"] = "Error Status 1";
    $return["MESSAGE"] = json_encode($d);
    return $return;
}
function extractStringdd3($string, $start, $end)
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