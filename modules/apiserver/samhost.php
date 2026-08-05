<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samhostname"] = "samhost";
$APIMODULE["samhostvisiblename"] = "samhost";
$APIMODULE["samhostnotes"] = "";
function samhost_activate()
{
    GatewayField("samhost", "text", "username", "", "User name", "30", "");
    GatewayField("samhost", "text", "password", "", "Password", "200", "");
}
function samhost_accoutinfo($VAL)
{
    $posted = [];
    $posted += ["Username" => $VAL["username"]];
    $posted += ["Password" => $VAL["password"]];
    $posted += ["Command" => "CheckUser"];
    $url = "https://samghost.is-a-chef.com/sam.php";
    $crul = curl_init();
    curl_setopt($crul, CURLOPT_HEADER, false);
    curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
    curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crul, CURLOPT_URL, $url);
    curl_setopt($crul, CURLOPT_PORT, 3434);
    curl_setopt($crul, CURLOPT_POST, true);
    curl_setopt($crul, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($crul, CURLOPT_POSTFIELDS, $posted);
    $arrResponse = curl_exec($crul);
    curl_close($crul);
    $arrResponse = json_decode($arrResponse, true);
    if ($arrResponse["STATUS"] == "OK") {
        $return["Credits available"] = $arrResponse["Credit"];
    } else {
        $return["ERROR"] = $arrResponse["ERROR"];
    }
    return $return;
}
function samhost_services($VAL)
{
    $return["Group"][0]["ID"] = "samhost";
    $return["Group"][0]["Name"] = "samhost";
    $return["Group"][0]["GroupType"] = "SERVER";
    $tool_id = 1;
    $return["Group"][0]["Tool"][$tool_id]["ID"] = $tool_id;
    $return["Group"][0]["Tool"][$tool_id]["ToolType"] = "SERVER";
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "Samhost Credits New User";
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
    $return["Group"][0]["Tool"][$tool_id]["Name"] = "Samhost Credits Existing User";
    $return["Group"][0]["Tool"][$tool_id]["QNT"] = 1;
    $return["Group"][0]["Tool"][$tool_id]["Credits"] = "1";
    $return["Group"][0]["Tool"][$tool_id]["Requires.Custom"] = $CustomFields;
    return $return;
}
function samhost_send($VAL)
{
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
        }
    }
    if ($VAL["API_ID"] == 1) {
        $posted = [];
        $posted += ["Username" => $VAL["username"]];
        $posted += ["Password" => $VAL["password"]];
        $posted += ["Prefix" => "SAMHOST"];
        $posted += ["Count" => 1];
        $posted += ["Credit" => $VAL["QNT"]];
        $url = "https://samghost.is-a-chef.com/sam.php";
        $crul = curl_init();
        curl_setopt($crul, CURLOPT_HEADER, false);
        curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crul, CURLOPT_URL, $url);
        curl_setopt($crul, CURLOPT_PORT, 3434);
        curl_setopt($crul, CURLOPT_POST, true);
        curl_setopt($crul, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crul, CURLOPT_POSTFIELDS, $posted);
        $rezultat = curl_exec($crul);
        curl_close($crul);
        $arrResponse = json_decode($rezultat, true);
        if (1 <= count($arrResponse["Users"])) {
            $return["SUCCESS"] = true;
            $return["CODES"] = "Username: " . $arrResponse["Users"][0]["Username"] . "<br />Password: " . $arrResponse["Users"][0]["Password"] . "<br />Credits: " . $arrResponse["Credit"];
        }
        if ($arrResponse["ERROR"]) {
            $return["ERROR"] = $arrResponse["ERROR"];
            $return["MESSAGE"] = $arrResponse["ERROR"];
        }
    }
    if ($VAL["API_ID"] == 2) {
        $posted = [];
        $posted += ["Username" => $VAL["username"]];
        $posted += ["Password" => $VAL["password"]];
        $posted += ["User" => $customfields["USERNAME"]];
        $posted += ["Credit" => $VAL["QNT"]];
        $url = "https://samghost.is-a-chef.com/sam.php";
        $crul = curl_init();
        curl_setopt($crul, CURLOPT_HEADER, false);
        curl_setopt($crul, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
        curl_setopt($crul, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crul, CURLOPT_URL, $url);
        curl_setopt($crul, CURLOPT_PORT, 3434);
        curl_setopt($crul, CURLOPT_POST, true);
        curl_setopt($crul, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($crul, CURLOPT_POSTFIELDS, $posted);
        echo $rezultat = curl_exec($crul);
        curl_close($crul);
        $arrResponse = json_decode($rezultat, true);
        if ($arrResponse["ERROR"]) {
            $return["ERROR"] = $arrResponse["ERROR"];
            $return["MESSAGE"] = $arrResponse["ERROR"];
        }
        if ($arrResponse["STATUS"] == "OK") {
            $return["SUCCESS"] = true;
            $return["CODES"] = $VAL["QNT"] . " CREDIT ADDED TO " . $customfields["USERNAME"];
        }
    }
    return $return;
}

?>