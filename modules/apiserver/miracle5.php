<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["miracle5name"] = "miracle5";
$APIMODULE["miracle5visiblename"] = "miracle5 (miraclesserver.com)";
$APIMODULE["miracle5notes"] = "miracle [miraclesserver.com]";
function miracle5_activate()
{
    GatewayField("miracle5", "text", "username", "", "Username", "500", "");
    GatewayField("miracle5", "text", "password", "", "Password", "500", "");
}
function miracle5_accoutinfo($VAL)
{
    $post[auth][username] = $VAL["username"];
    $post[auth][password] = $VAL["password"];
    $post[auth][actiontype] = "Login";
    $request = json_decode(initCurl("https://miraclesserver.com/mat/wbsrvc.php", "", "", "", $post), true)["result"];
    if ($request[statusid] == 0) {
        $return["ERROR"] = $request[info];
    } else {
        if ($request[statusid] == 1) {
            $return["Credits available"] = $request[info][AvailableCredit];
            $return["Account email"] = $request[info][TotalCredit];
            $return["Permision"] = implode(",", $request[info][permision_details][permision_list]);
            $return["Packs"] = implode(",", $request[info][allowed_packs][pack_list]);
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    return $return;
}
function miracle5_services($VAL)
{
    $CustomFields = $__CustomFields = [];
    $__CustomFields[fieldtype] = "text";
    $__CustomFields[fieldoptions] = "";
    $__CustomFields[type] = "serviceimei";
    $__CustomFields[fieldname] = "Serial No";
    $__CustomFields[description] = "LicenseKey/Serial to Renew";
    $__CustomFields[regexpr] = "";
    $__CustomFields[adminonly] = "";
    $__CustomFields[required] = "on";
    $__CustomFields[enc] = "";
    $CustomFields[] = $__CustomFields;
    $post[auth][username] = $VAL["username"];
    $post[auth][password] = $VAL["password"];
    $post[auth][actiontype] = "Login";
    $request = json_decode(initCurl("https://miraclesserver.com/mat/wbsrvc.php", "", "", "", $post), true)["result"];
    if ($request[statusid] == 0) {
        $return["ERROR"] = $request[info];
    } else {
        if ($request[statusid] == 1) {
            $return["Group"][0]["ID"] = "Add/Renew Pack To SerialNumber";
            $return["Group"][0]["Name"] = "Add/Renew Pack To SerialNumber";
            $return["Group"][0]["GroupType"] = "SERVER";
            foreach ($request[info][allowed_packs][pack_list] as $k => $v) {
                $toolID = $v;
                $return["Group"][0]["Tool"][$toolID]["ID"] = $toolID;
                $return["Group"][0]["Tool"][$toolID]["ToolType"] = "SERVER";
                $return["Group"][0]["Tool"][$toolID]["Name"] = $v;
                $return["Group"][0]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
                $return["Group"][0]["Tool"][$toolID]["Credits"] = "1";
            }
            $toolID = "Renew SerialNumber License";
            $return["Group"][1]["ID"] = "Renew SerialNumber License";
            $return["Group"][1]["Name"] = "Renew SerialNumber License";
            $return["Group"][1]["GroupType"] = "SERVER";
            $return["Group"][1]["Tool"][$toolID]["ID"] = "Renew SerialNumber License";
            $return["Group"][1]["Tool"][$toolID]["ToolType"] = "SERVER";
            $return["Group"][1]["Tool"][$toolID]["Name"] = "Renew SerialNumber License";
            $return["Group"][1]["Tool"][$toolID]["Requires.Custom"] = $CustomFields;
            $return["Group"][1]["Tool"][$toolID]["Credits"] = "1";
            return $return;
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    return $return;
}
function miracle5_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    $post[auth][username] = $VAL["username"];
    $post[auth][password] = $VAL["password"];
    if ($VAL["API_ID"] == "Renew SerialNumber License") {
        $post[auth][actiontype] = "Renew SerialNumber License";
        $post[auth][actiondata][0] = ["serialnumber" => trim($customfields["Serial No"])];
    } else {
        $post[auth][actiontype] = "Add/Renew Pack To SerialNumber";
        if ($VAL["API_ID"] == "FRP Tool 4 in 1") {
            $_packlist = ["FRP Tool 4 in 1"];
        } else {
            if ($VAL["API_ID"] == "Huawei 4 in 1") {
                $_packlist = ["1" => "Huawei 4 in 1"];
            }
        }
        $post[auth][actiondata][0] = ["allowed_packs" => ["pack_list" => $_packlist], "serialnumber" => trim($customfields["Serial No"])];
    }
    $request = json_decode(initCurl("https://miraclesserver.com/mat/wbsrvc.php", "", "", "", $post), true)["result"];
    $return = [];
    if ($request[statusid] == 0) {
        $return["ERROR"] = json_encode($request) . json_encode($_packlist);
        $return["MESSAGE"] = nl2br($request[info]);
    } else {
        if ($request[statusid] == 1) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = $request[info];
            $return["CODES"] = $request[info];
        }
    }
    unset($send);
    unset($request);
    return $return;
}

?>