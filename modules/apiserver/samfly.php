<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samflyname"] = "samfly";
$APIMODULE["samflyvisiblename"] = "samfly";
$APIMODULE["samflynotes"] = "";
function samfly_activate()
{
    GatewayField("samfly", "text", "email", "", "Login Email", "30", "");
    GatewayField("samfly", "text", "apikey", "", "APi KEY", "200", "");
}
function samfly_accoutinfo($VAL)
{
}
function samfly_services($VAL)
{
    $return["Group"][0]["ID"] = "samfly";
    $return["Group"][0]["Name"] = "samfly";
    $return["Group"][0]["GroupType"] = "IMEI";
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "PC Name";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $tool_id = "SAMPD36";
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "IMEI";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "SAMSUNG FRP ALL Models (SAMPD36)";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    $tool_id = "SAMSUNG402";
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "IMEI";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "SAMSUNG FRP ALL Models (SAMSUNG402)";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    $tool_id = "ALL";
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "IMEI";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "SAMSUNG FRP ALL Models (ALL)";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    return $return;
}
function samfly_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $email = $VAL["email"];
    $apikey = $VAL["apikey"];
    $refNo = $VAL["ORDERID"] . rand(1111111, 9999999);
    $quantity = $VAL["QNT"];
    $PCName = $customfields["PC Name"];
    $tollid = $VAL["API_ID"];
    $postfield["OrderPostID"] = $refNo;
    $postfield["email"] = $email;
    $postfield["apitoken"] = $apikey;
    $postfield["pd_code"] = $tollid;
    $postfield["qty"] = $quantity;
    $postfield["pcname"] = $PCName;
    $url = "http://www.samfrp.com/api/api.php?action=neworder";
    $res = initCurlApi($url, $postfield);
    if (containsWEssAA("Error", $res)) {
        $return["ERROR"] = $res;
        $return["MESSAGE"] = "Error! Try again";
        return $return;
    }
    if (containsWEssAA("order_info", $res)) {
        $res_decode = json_decode($res, true);
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $res;
        $return["ID"] = $res_decode["order_info"][0]["od_id"];
        return $return;
    }
    return false;
}
function samfly_get($VAL)
{
    $url = "http://www.samfrp.com/api/api.php?action=orderinfo&orderId=" . $VAL["API_ORDER_ID"];
    $res = initCurlApi($url);
    $res_decode = json_decode($res, true);
    if ($res_decode["imei_info"][0]["status"] == "Completed") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $res;
        $return["CODES"] = "Process completed";
        return $return;
    }
    if ($res_decode["imei_info"][0]["status"] == "Cancel") {
        $return["ERROR"] = $res;
        $return["MESSAGE"] = "Please try again!";
        return $return;
    }
}
function containsWEssAA($needle, $haystack)
{
    return strpos($haystack, $needle) !== false;
}

?>