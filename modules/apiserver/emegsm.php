<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["emegsmname"] = "emegsm";
$APIMODULE["emegsmvisiblename"] = "emegsm.com";
$APIMODULE["emegsmnotes"] = "Connect emegsm.com ";
function emegsm_activate()
{
    GatewayField("emegsm", "text", "url", "http://pms.emegsm.com/Agent/En/Ajax/", "Api URL", "200", "");
    GatewayField("emegsm", "text", "resellerid", "", "Reseller ID", "200", "");
    GatewayField("emegsm", "text", "resellerpwd", "", "Reseller Password", "200", "");
}
function emegsm_accoutinfo($VAL)
{
    $post = NULL;
    $request = json_decode(initCurl($VAL["url"] . "Login.aspx?Command=Api&LoginId=" . urlencode($VAL["resellerid"]) . "&Password=" . urlencode($VAL["resellerpwd"]), $post), true);
    if ($request["nResult"] == 1) {
        $return["info"] = $request["vcResult"];
        return $return;
    }
    $return["ERROR"] = "Could not communicate with the api";
    return $return;
}
function emegsm_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "UserID";
    $__CustomFields[description] = "User ID";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $return["Group"][1]["ID"] = "emegsm";
    $return["Group"][1]["Name"] = "emegsm";
    $return["Group"][1]["GroupType"] = "SERVER";
    $toolID = 1;
    $return["Group"][1]["Tool"][$toolID]["ID"] = 1;
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "[Recharge] Credits Card";
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
    $toolID = 2;
    $return["Group"][1]["Tool"][$toolID]["ID"] = 2;
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "[Authorized] Standard Edition";
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
    $toolID = 3;
    $return["Group"][1]["Tool"][$toolID]["ID"] = 3;
    $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
    $return["Group"][1]["Tool"][$toolID]["Name"] = "[Authorized] Professional Edition";
    $return["Group"][1]["Tool"][$toolID]["QNT"] = 1;
    $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
    $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
    return $return;
}
function emegsm_send($VAL)
{
    global $debug_output;
    $RechargeType = 0;
    $post = NULL;
    $request = json_decode(initCurl($VAL["url"] . "Recharge.aspx?Command=Recharge&LoginId=" . urlencode($VAL["UserID"]) . "&ConfirmStatus=1&FeeType=" . $VAL["API_ID"] . "&Volume=" . $VAL["QNT"], $post), true);
    if ($request["nResult"] == 1) {
        $return["info"] = $request["vcResult"];
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = $request["vcResult"];
        return $return;
    }
    $return["ERROR"] = "Could not communicate with the api";
    $return["MSG"] = "Could not communicate with the api";
    return $return;
}
function emegsm_get($VAL)
{
    return $return;
}

?>