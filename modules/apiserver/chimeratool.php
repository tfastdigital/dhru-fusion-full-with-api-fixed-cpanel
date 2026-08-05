<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["chimeratoolname"] = "chimeratool";
$APIMODULE["chimeratoolvisiblename"] = "Chimera Tool";
$APIMODULE["chimeratoolnotes"] = "Custom field required name=Username";
function chimeratool_activate()
{
    GatewayField("chimeratool", "text", "username", "", "Username", "500", "");
    GatewayField("chimeratool", "text", "apikey", "", "APi KEY", "500", "");
}
function chimeratool_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/chimeratool.class.php";
    $chimera = new ChimeraApi(trim($VAL["username"]), trim($VAL["apikey"]));
    $request = $chimera->getInfo();
    if ($request["success"]) {
        $return["Transfers Count"] = $request["transfersCount"];
        $return["Credits available"] = $request["creditBalance"];
        return $return;
    }
    $return["ERROR"] = $request[message];
    return $return;
}
function chimeratool_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/chimeratool.class.php";
    $chimera = new ChimeraApi(trim($VAL["username"]), trim($VAL["apikey"]));
    $request = $chimera->availableLicences();
    if ($request["success"]) {
        $__CustomFields = $CustomFields = [];
        $_CustomFields = ["Username"];
        foreach ($_CustomFields as $fildname) {
            $__CustomFields[fieldtype] = "text";
            $__CustomFields[fieldoptions] = "";
            $__CustomFields[type] = "serviceimei";
            $__CustomFields[fieldname] = $fildname;
            $__CustomFields[description] = "";
            $__CustomFields[regexpr] = "";
            $__CustomFields[adminonly] = "";
            $__CustomFields[required] = "on";
            $__CustomFields[enc] = "";
            $__CustomFields[lostfocus_action] = "checkChimeratoolUsername(this);";
            $CustomFields[] = $__CustomFields;
        }
        $Group = 1;
        $return["Group"][$Group]["Name"] = "Chimera Tool";
        $return["Group"][$Group]["GroupType"] = "SERVER";
        $return["Group"][$Group]["ID"] = $Group;
        foreach ($request["licences"] as $Tools => $SERVICES) {
            $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["name"];
            $return["Group"][$Group]["Tool"][$Tools]["Name"] = $SERVICES["friendlyName"];
            $return["Group"][$Group]["Tool"][$Tools]["ToolType"] = "SERVER";
            $return["Group"][$Group]["Tool"][$Tools]["Message"] = "";
            $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES["price"];
            $return["Group"][$Group]["Tool"][$Tools]["Requires.Custom"] = $CustomFields;
        }
        $return["Group"][$Group]["Tool"][3]["ID"] = "Credits";
        $return["Group"][$Group]["Tool"][3]["Name"] = "Credits (Any Quantity)";
        $return["Group"][$Group]["Tool"][3]["QNT"] = 1;
        $return["Group"][$Group]["Tool"][3]["ToolType"] = "SERVER";
        $return["Group"][$Group]["Tool"][3]["Message"] = "";
        $return["Group"][$Group]["Tool"][3]["Credits"] = 1;
        $return["Group"][$Group]["Tool"][3]["Requires.Custom"] = $CustomFields;
    } else {
        $return["ERROR"] = $request[message];
    }
    return $return;
}
function chimeratool_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[ucfirst(strtolower($customfield["name"]))] = $customfield["value"];
        }
    }
    include_once ROOTDIR . "/modules/apiserver/class/chimeratool.class.php";
    $chimera = new ChimeraApi(trim($VAL["username"]), trim($VAL["apikey"]));
    $request = $chimera->checkUser($customfields[Username]);
    if ($request[success]) {
        $userid = $request[userId];
        if ($VAL[API_ID] == "Credits") {
            $request = $chimera->transferCredit($userid, $VAL[QNT]);
            if ($request[success]) {
                $return["SUCCESS"] = true;
                $return["CODES"] = $customfields[Username] . " Credited successfully";
                $return["ID"] = "";
            } else {
                $return["ERROR"] = "Not enough credits";
                $return["MESSAGE"] = "Unknown error,please try again";
            }
        } else {
            $request = $chimera->sellLicence($userid, "user", $VAL[API_ID]);
            if ($request[success]) {
                $return["SUCCESS"] = true;
                $return["CODES"] = "Successfully";
                $return["ID"] = "";
            } else {
                $return["ERROR"] = $request["message"];
                $return["MESSAGE"] = "Unknown error,please try again";
            }
        }
    } else {
        $return["ERROR"] = $request["message"];
        $return["MESSAGE"] = $request["message"];
    }
    return $return;
}
function chimeratool_get($VAL)
{
}

?>