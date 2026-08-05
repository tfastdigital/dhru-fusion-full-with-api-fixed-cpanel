<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["z3xname"] = "z3x";
$APIMODULE["z3xvisiblename"] = "z3x-team.com";
$APIMODULE["z3xnotes"] = "z3x-team.com v1.3";
function z3x_activate()
{
    GatewayField("z3x", "text", "apikey", "", "APi KEY", "500", "");
    GatewayField("z3x", "system", "apiurl", "https://cp.z3x-team.com/rapi/", "APi url", "500", "");
}
function z3x_accoutinfo($VAL)
{
    $send["key"] = $VAL["apikey"];
    $send["ver"] = 1;
    $request = initCurl($VAL["apiurl"] . "/credits_left", $send);
    $request = json_decode($request, true);
    printJson($request);
    if (!$request["ErrorCode"]) {
        $return = $request[Data];
        $_SESSION[z3x] = $request[Data];
        $return["Credits available"] = $request[Data]["sams_crd"];
        return $return;
    }
    $return["ERROR"] = $request[ErrorTxt];
    return $return;
}
function z3x_services($VAL)
{
    $send["key"] = $VAL["apikey"];
    $request = initCurl($VAL["apiurl"] . "/get-tools", $send);
    $request = json_decode($request, true);
    if (!$request["error"]) {
        $Group = 1;
        $return["Group"][$Group]["Name"] = "z3x";
        $return["Group"][$Group]["ID"] = $Group;
        $return["Group"][$Group]["GroupType"] = "SERVER";
        $__CustomFields1[fieldtype] = "text";
        $__CustomFields1[fieldoptions] = "";
        $__CustomFields1[type] = "serviceimei";
        $__CustomFields1[fieldname] = "SERIAL_NUMBER";
        $__CustomFields1[description] = "";
        $__CustomFields1[regexpr] = "";
        $__CustomFields1[adminonly] = "";
        $__CustomFields1[required] = "on";
        $__CustomFields1[enc] = "";
        $__CustomFields1[lostfocus_action] = "";
        $__CustomFields2[fieldtype] = "text";
        $__CustomFields2[fieldoptions] = "";
        $__CustomFields2[type] = "serviceimei";
        $__CustomFields2[fieldname] = "REFILL_LOGIN";
        $__CustomFields2[description] = "";
        $__CustomFields2[regexpr] = "";
        $__CustomFields2[adminonly] = "";
        $__CustomFields2[required] = "on";
        $__CustomFields2[enc] = "";
        $__CustomFields2[lostfocus_action] = "";
        $__CustomFields[fieldtype] = "dropdown";
        $__CustomFields[fieldoptions] = "china,jtag,jtag_plus,jtag_upd,lg,sams_pro,sams_upd";
        $__CustomFields[type] = "serviceimei";
        $__CustomFields[fieldname] = "Activate";
        $__CustomFields[description] = "";
        $__CustomFields[regexpr] = "";
        $__CustomFields[adminonly] = "";
        $__CustomFields[required] = "on";
        $__CustomFields[enc] = "";
        $__CustomFields[lostfocus_action] = "";
        $__CustomFields3[fieldtype] = "dropdown";
        $__CustomFields3[fieldoptions] = "Samsung Tool";
        $__CustomFields3[type] = "serviceimei";
        $__CustomFields3[fieldname] = "Type";
        $__CustomFields3[description] = "";
        $__CustomFields3[regexpr] = "";
        $__CustomFields3[adminonly] = "";
        $__CustomFields3[required] = "on";
        $__CustomFields3[enc] = "";
        $__CustomFields3[lostfocus_action] = "";
        $CustomFields[] = $__CustomFields;
        $CustomFields[] = $__CustomFields1;
        $CustomFieldsNewAccount[] = $__CustomFields3;
        $CustomFieldsRefill[] = $__CustomFields2;
        $CustomFieldsRefill[] = $__CustomFields3;
        $return["Group"][$Group]["Tool"][0]["ID"] = 1;
        $return["Group"][$Group]["Tool"][0]["Name"] = "z3x Activations";
        $return["Group"][$Group]["Tool"][0]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][0]["Message"] = "";
        $return["Group"][$Group]["Tool"][0]["Credits"] = 1;
        $return["Group"][$Group]["Tool"][0]["Requires.Custom"] = $CustomFields;
        $return["Group"][$Group]["Tool"][2]["ID"] = "new-30";
        $return["Group"][$Group]["Tool"][2]["Name"] = "z3x Unlock Credits Pack of 30 Credits (New Account)";
        $return["Group"][$Group]["Tool"][2]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][2]["Message"] = "";
        $return["Group"][$Group]["Tool"][2]["Credits"] = 30;
        $return["Group"][$Group]["Tool"][2]["Requires.Custom"] = $CustomFieldsNewAccount;
        $return["Group"][$Group]["Tool"][3]["ID"] = "new-50";
        $return["Group"][$Group]["Tool"][3]["Name"] = "z3x Unlock Credits Pack of 50 Credits (New Account)";
        $return["Group"][$Group]["Tool"][3]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][3]["Message"] = "";
        $return["Group"][$Group]["Tool"][3]["Credits"] = 50;
        $return["Group"][$Group]["Tool"][3]["Requires.Custom"] = $CustomFieldsNewAccount;
        $return["Group"][$Group]["Tool"][4]["ID"] = "new-100";
        $return["Group"][$Group]["Tool"][4]["Name"] = "z3x Unlock Credits Pack of 100 Credits (New Account)";
        $return["Group"][$Group]["Tool"][4]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][4]["Message"] = "";
        $return["Group"][$Group]["Tool"][4]["Credits"] = 100;
        $return["Group"][$Group]["Tool"][4]["Requires.Custom"] = $CustomFieldsNewAccount;
        $return["Group"][$Group]["Tool"][5]["ID"] = "refill-30";
        $return["Group"][$Group]["Tool"][5]["Name"] = "z3x Unlock Refill Credits Pack of 30 Credits";
        $return["Group"][$Group]["Tool"][5]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][5]["Message"] = "";
        $return["Group"][$Group]["Tool"][5]["Credits"] = 30;
        $return["Group"][$Group]["Tool"][5]["Requires.Custom"] = $CustomFieldsRefill;
        $return["Group"][$Group]["Tool"][6]["ID"] = "refill-50";
        $return["Group"][$Group]["Tool"][6]["Name"] = "z3x Unlock Refill Credits Pack of 50 Credits";
        $return["Group"][$Group]["Tool"][6]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][6]["Message"] = "";
        $return["Group"][$Group]["Tool"][6]["Credits"] = 50;
        $return["Group"][$Group]["Tool"][6]["Requires.Custom"] = $CustomFieldsRefill;
        $return["Group"][$Group]["Tool"][7]["ID"] = "refill-100";
        $return["Group"][$Group]["Tool"][7]["Name"] = "z3x Unlock Refill Credits Pack of 100 Credits";
        $return["Group"][$Group]["Tool"][7]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][7]["Message"] = "";
        $return["Group"][$Group]["Tool"][7]["Credits"] = 100;
        $return["Group"][$Group]["Tool"][7]["Requires.Custom"] = $CustomFieldsRefill;
    } else {
        if ($request["errno"]) {
            $return["ERROR"] = $request["error"];
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    return $return;
}
function z3x_send($VAL)
{
    $_CreditTypes = ["samsung tool" => "sams_crd"];
    $send["key"] = $VAL["apikey"];
    $send["ver"] = 1;
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    if ($VAL["API_ID"] == 1) {
        $send["activation"] = $customfields["Activate"];
        $send["card"] = $VAL["SERIAL_NUMBER"];
    } else {
        $_serviceid = explode("-", $VAL["API_ID"]);
        list($serviceid, $crd_count) = $_serviceid;
        $send["activation"] = $_CreditTypes[trim(strtolower($customfields["Type"]))];
        $send["crd_count"] = $crd_count;
        if ($serviceid == "refill") {
            $send["crd_refill_login"] = $customfields["REFILL_LOGIN"];
        }
    }
    $request = initCurl($VAL["apiurl"] . "/process", $send);
    $request = json_decode($request, true);
    if (!$request["ErrorCode"]) {
        $_code = "Activated Successfully";
        $_login = $request[Data][login];
        if ($request[Data][action] == "create") {
            $_code = "Login : " . $_login . " <br /> Password : " . $request[Data][password] . " <br /> ";
        }
        if ($request[Data][action] == "refill") {
            $_code = "Credits " . $request[Data][count] . " refilled with login " . $request[Data][login];
        }
        $return["SUCCESS"] = true;
        $return["CODES"] = $_code;
    } else {
        $return["ERROR"] = $request["ErrorTxt"];
        $return["MESSAGE"] = $request["ErrorTxt"];
    }
    return $return;
}

?>