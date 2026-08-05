<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samkeyname"] = "samkey";
$APIMODULE["samkeyvisiblename"] = "samkey.org";
$APIMODULE["samkeynotes"] = "";
function samkey_activate()
{
    GatewayField("samkey", "text", "username", "", "User name", "30", "");
    GatewayField("samkey", "text", "apikey", "", "APi KEY", "200", "");
    GatewayField("samkey", "System", "apiurl", "http://samkey.org/api/index.php", "apiurl", "30", "");
}
function samkey_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/samkey.class.php";
    $objSAMKEYAPI = new SAMKEYAPI();
    $objSAMKEYAPI->API_KEY = $VAL["apikey"];
    $objSAMKEYAPI->USER_NAME = $VAL["username"];
    $arrResponse = $objSAMKEYAPI->action("accountInfo");
    if (isset($arrResponse["ERROR"])) {
        if (isset($arrResponse["ERROR"][0]["MESSAGE"])) {
            $return["ERROR"] = $arrResponse["ERROR"][0]["MESSAGE"];
        }
    } else {
        if (isset($arrResponse["SUCCESS"]) && is_array($arrResponse["SUCCESS"][0])) {
            if (isset($arrResponse["SUCCESS"][0]["CREDITS"])) {
                $return["Credits available"] = $arrResponse["SUCCESS"][0]["CREDITS"];
            }
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    return $return;
}
function samkey_services($VAL)
{
    $return["Group"][0]["ID"] = "samkey.org";
    $return["Group"][0]["Name"] = "samkey.org";
    $return["Group"][0]["GroupType"] = "SERVER";
    $tool_id = 1;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "Samkey Credits for New User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
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
    $tool_id = 2;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "Samkey Credits for Existing User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "FingerPrint";
    $__CustomFields[description] = "";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $tool_id = 3;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "Create Samkey TMO User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    return $return;
}
function samkey_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    include_once ROOTDIR . "/modules/apiserver/class/samkey.class.php";
    $objSAMKEYAPI = new SAMKEYAPI();
    $objSAMKEYAPI->API_KEY = $VAL["apikey"];
    $objSAMKEYAPI->USER_NAME = $VAL["username"];
    $refNo = $VAL[ORDERID];
    $quantity = $VAL[QNT];
    if ($VAL["API_ID"] == 3 || $VAL["API_ID"] == 1) {
        $fingerPrint = $customfields["FingerPrint"];
        if ($VAL["API_ID"] == 1) {
            $serviceId = "2";
            $arrResponse = $objSAMKEYAPI->action("placeorder_tmo", "", "", $refNo, "", $quantity, $serviceId);
        } else {
            $serviceId = "1";
            $arrResponse = $objSAMKEYAPI->action("placeorder_tmo", "", "", $refNo, $fingerPrint, $quantity, $serviceId);
        }
        if (isset($arrResponse["ERROR"]) && isset($arrResponse["ERROR"][0]["MESSAGE"])) {
            $return["ERROR"] = $arrResponse["ERROR"][0]["MESSAGE"];
            $return["MESSAGE"] = $arrResponse["ERROR"][0]["MESSAGE"];
        }
        if (isset($arrResponse["SUCCESS"]) && is_array($arrResponse["SUCCESS"][0]) && isset($arrResponse["SUCCESS"][0]["USERNAME"])) {
            $return["SUCCESS"] = true;
            $return["CODES"] = "Username: " . $arrResponse["SUCCESS"][0]["USERNAME"] . "<br />Password: " . $arrResponse["SUCCESS"][0]["PASSWORD"];
        }
    }
    if ($VAL["API_ID"] == 2) {
        $userName = $customfields["USERNAME"];
        $arrResponse = $objSAMKEYAPI->action("updateorder", $quantity, $userName, $refNo);
        print_r($arrResponse);
        if (isset($arrResponse["ERROR"]) && isset($arrResponse["ERROR"][0]["MESSAGE"])) {
            $return["ERROR"] = $arrResponse["ERROR"][0]["MESSAGE"];
            $return["MESSAGE"] = $arrResponse["ERROR"][0]["MESSAGE"];
        }
        if (isset($arrResponse["SUCCESS"]) && is_array($arrResponse["SUCCESS"][0]) && isset($arrResponse["SUCCESS"][0]["MESSAGE"])) {
            $return["SUCCESS"] = true;
            $return["CODES"] = "Credits added for " . $userName . ": " . $arrResponse["SUCCESS"][0]["MESSAGE"];
        }
    }
    return $return;
}

?>