<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["samkeyusname"] = "samkeyus";
$APIMODULE["samkeyusvisiblename"] = "samkey.us";
$APIMODULE["samkeyusnotes"] = "";
function samkeyus_activate()
{
    GatewayField("samkeyus", "text", "username", "", "User name", "30", "");
    GatewayField("samkeyus", "text", "apikey", "", "APi KEY", "200", "");
    GatewayField("samkeyus", "System", "apiurl", "http://samkey.us/public", "apiurl", "30", "");
}
function samkeyus_accoutinfo($VAL)
{
    define("REQUESTFORMAT", "JSON");
    define("SAMKEY_URL", "http://samkey.us");
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/samkeyus.class.php";
    $api = new SAMKEYFusion();
    $para = [];
    $request = $api->action("accountinfo", $para);
    if ($request[gsmhubsite]) {
        $_scripttype = "gsmhub";
    } else {
        if ($request[apiversion] == "2.0.0") {
            $_scripttype = "gsmtool";
        } else {
            $_scripttype = "";
        }
    }
    if ($request["SUCCESS"]) {
        $return["Account email"] = $request["SUCCESS"][0]["AccoutInfo"]["mail"];
        $return["Credits available"] = $request["SUCCESS"][0]["AccoutInfo"]["credit"];
        $return["currency"] = $request["SUCCESS"][0]["AccoutInfo"]["currency"];
        $return["scripttype"] = $_scripttype;
        if ($request["SUCCESS"][0]["AccoutInfo"]["currency"]) {
            $return["currency"] = $request["SUCCESS"][0]["AccoutInfo"]["currency"];
        }
        return $return;
    }
    if ($request["ERROR"]) {
        $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function samkeyus_services($VAL)
{
    define("REQUESTFORMAT", "JSON");
    define("SAMKEY_URL", "http://samkey.us");
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/samkeyus.class.php";
    $api = new SAMKEYFusion();
    if ($VAL["scripttype"] == "gsmhub") {
        $request2 = $api->action("serverservicelist");
        $requestTypeList = $api->action("serverservicetypelist");
        if ($request2["SUCCESS"]) {
            foreach ($request2["SUCCESS"][0]["LIST"] as $Group => $Tools) {
                if ($Group != "GsmHub Products") {
                    $return["Group"][$Group]["Name"] = $Group;
                    $return["Group"][$Group]["GroupType"] = "SERVER";
                    $return["Group"][$Group]["ID"] = $Group;
                    foreach ($Tools["SERVICES"] as $Tools => $SERVICES) {
                        $CustomFields = "";
                        $_CustomFields = $SERVICES["REQUIRED"] ? explode("|", $SERVICES["REQUIRED"]) : "";
                        if (is_array($_CustomFields)) {
                            $__CustomFields = $CustomFields = [];
                            foreach ($_CustomFields as $fildname) {
                                if ($fildname == "USERTYPE") {
                                    $__CustomFields[fieldtype] = "dropdown";
                                    $__CustomFields[fieldoptions] = "NewUser,ExistingUser";
                                } else {
                                    $__CustomFields[fieldtype] = "text";
                                    $__CustomFields[fieldoptions] = "";
                                }
                                $__CustomFields[type] = "serviceimei";
                                $__CustomFields[fieldname] = $fildname;
                                $__CustomFields[description] = "";
                                $__CustomFields[regexpr] = "";
                                $__CustomFields[adminonly] = "";
                                $__CustomFields[required] = "on";
                                $__CustomFields[enc] = "";
                                $CustomFields[] = $__CustomFields;
                            }
                        }
                        $_tool_id = $SERVICES["SERVICEID"];
                        $_this_tool_has_types = false;
                        $this_tool_types = [];
                        foreach ($requestTypeList["SUCCESS"][0]["LIST"] as $v) {
                            if ($v["tool_id"] == $_tool_id) {
                                $_this_tool_has_types = true;
                                $_this_tool_types[Name] = $v[name];
                                $_this_tool_types[Credits] = $v[price];
                                $_this_tool_types[TypeID] = $v[id];
                                $this_tool_types[] = $_this_tool_types;
                            }
                        }
                        if ($_this_tool_has_types) {
                            $Group = $SERVICES["SERVICENAME"];
                            $return["Group"][$Group]["Name"] = $SERVICES["SERVICENAME"];
                            $return["Group"][$Group]["GroupType"] = "SERVER";
                            $return["Group"][$Group]["ID"] = $Group;
                            foreach ($this_tool_types as $Tools => $v) {
                                $ADDITIONAL_NVP = unserialize($SERVICES[ADDITIONAL_NVP]);
                                $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["SERVICEID"];
                                $return["Group"][$Group]["Tool"][$Tools]["TypeID"] = $v["TypeID"];
                                $return["Group"][$Group]["Tool"][$Tools]["ToolType"] = "SERVER";
                                $return["Group"][$Group]["Tool"][$Tools]["QNT"] = $ADDITIONAL_NVP[hide_quantity] ? 0 : 1;
                                $return["Group"][$Group]["Tool"][$Tools]["SERVER"] = 1;
                                $return["Group"][$Group]["Tool"][$Tools]["Name"] = $v["Name"];
                                $return["Group"][$Group]["Tool"][$Tools]["Message"] = html_entity_decode(utf8_decode($SERVICES["INFO"]));
                                $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $v[Credits];
                                $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $SERVICES["TIME"];
                                $return["Group"][$Group]["Tool"][$Tools]["Requires.Custom"] = $CustomFields;
                                $return["Group"][$Group]["Tool"][$Tools]["ADDITIONAL_NVP"] = $ADDITIONAL_NVP;
                            }
                        } else {
                            $ADDITIONAL_NVP = unserialize($SERVICES[ADDITIONAL_NVP]);
                            $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["SERVICEID"];
                            $return["Group"][$Group]["Tool"][$Tools]["ToolType"] = "SERVER";
                            $return["Group"][$Group]["Tool"][$Tools]["QNT"] = $ADDITIONAL_NVP[hide_quantity] ? 0 : 1;
                            $return["Group"][$Group]["Tool"][$Tools]["SERVER"] = 1;
                            $return["Group"][$Group]["Tool"][$Tools]["Name"] = $SERVICES["SERVICENAME"];
                            $return["Group"][$Group]["Tool"][$Tools]["Message"] = html_entity_decode(utf8_decode($SERVICES["INFO"]));
                            $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES[CREDIT];
                            $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $SERVICES["TIME"];
                            $return["Group"][$Group]["Tool"][$Tools]["Requires.Custom"] = $CustomFields;
                            $return["Group"][$Group]["Tool"][$Tools]["ADDITIONAL_NVP"] = $ADDITIONAL_NVP;
                        }
                    }
                }
            }
        }
    }
    return $return;
}
function samkeyus_send($VAL)
{
    global $debug_output;
    global $CustomFieldsMap;
    define("REQUESTFORMAT", "JSON");
    define("SAMKEY_URL", "http://samkey.us");
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/samkeyus.class.php";
    $api = new SAMKEYFusion();
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            $customfields[$customfield["name"]] = $customfield["value"];
            if ($CustomFieldsMap) {
                $sendArr[$CustomFieldsMap[trim($customfield["name"])]] = $customfield["value"];
            }
        }
    }
    $sendArr["customfield"] = base64_encode(json_encode($customfields));
    $sendArr["ID"] = $VAL["API_ID"];
    $sendArr["serviceId"] = $VAL["API_ID"];
    $sendArr["IMEI"] = $VAL["IMEI"];
    $sendArr["QNT"] = $VAL["QNT"];
    $sendArr["SERVER"] = $VAL["SERVER"];
    $sendArr["MODELID"] = $VAL["API_MODEL_ID"];
    $sendArr["PROVIDERID"] = $VAL["API_PROVIDER_ID"];
    $sendArr["Network"] = $VAL["API_PROVIDER_ID"];
    $sendArr["PIN"] = $VAL["PIN"];
    $sendArr["KBH"] = $VAL["KBH"];
    $sendArr["MEP"] = $VAL["API_MEP_ID"];
    $sendArr["PRD"] = $VAL["PRD"];
    $sendArr["TYPE"] = $VAL["TYPE"];
    $sendArr["LOCKS"] = $VAL["LOCKS"];
    $sendArr["REFERENCE"] = $VAL["REFERENCE"];
    $sendArr["SN"] = $VAL["SN"];
    $sendArr["SecRO"] = $VAL["SecRO"];
    if ($VAL[scripttype] == "gsmhub" && $VAL[SERVER]) {
        if ($VAL[API_TYPEID]) {
            $customfields[service_type_id] = $VAL[API_TYPEID];
        }
        if ($customfields) {
            $sendArr[REQUIRED] = json_encode($customfields);
        }
        $sendArr[QUANTITY] = $VAL["QNT"];
        $request = $api->action("placeserverorder", $sendArr);
    } else {
        $request = $api->action("placeimeiorder", $sendArr);
    }
    if ($debug_output) {
        echo "<h2>Module Send Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
        print_r($request);
        echo "<hr />";
    }
    $sendArr = NULL;
    print_r($request);
    if ($request["SUCCESS"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($request["SUCCESS"][0]["MESSAGE"]);
        $return["ID"] = $request["SUCCESS"][0]["REFERENCEID"];
    } else {
        if ($request["ERROR"]) {
            $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
            $return["MESSAGE"] = $request["ERROR"][0]["MESSAGE"] . nl2br($request["ERROR"][0]["FULL_DESCRIPTION"]);
        }
    }
    return $return;
}
function samkeyus_get($VAL)
{
    define("REQUESTFORMAT", "JSON");
    define("SAMKEY_URL", "http://samkey.us");
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    include_once ROOTDIR . "/modules/apiserver/class/samkeyus.class.php";
    $api = new SAMKEYFusion();
    if ($VAL[scripttype] == "gsmhub" && $VAL[SERVER]) {
        $request = $api->action("getserverorder", ["ID" => $VAL["API_ORDER_ID"]]);
    } else {
        if ($VAL[scripttype] == "gsmtool" && $VAL[SERVER]) {
            include_once ROOTDIR . "/modules/apiserver/class/gsmtool.class.php";
            $api = new gsmtool();
            $request = $api->action("getserverorder", $VAL["apikey"], $VAL["apiurl"], $VAL["username"], ["orderId" => $VAL["API_ORDER_ID"]]);
            if ($request[result][serverorder][0]) {
                if ($request[result][serverorder][0][statusId] == 2) {
                    $request["SUCCESS"][0]["STATUS"] = 4;
                    $request["SUCCESS"][0]["CODE"] = $request[result][serverorder][0][code];
                }
                if ($request[result][serverorder][0][statusId] == 3) {
                    $request["SUCCESS"][0]["STATUS"] = 3;
                    $request["SUCCESS"][0]["CODE"] = $request[result][serverorder][0][code];
                }
            }
        } else {
            $request = $api->action("getimeiorder", ["ID" => $VAL["API_ORDER_ID"]]);
        }
    }
    if ($request["SUCCESS"]) {
        if ($request["SUCCESS"][0]["STATUS"] == "4") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars("Order Found");
            $return["CODES"] = $request["SUCCESS"][0]["CODE"];
        }
        if ($request["SUCCESS"][0]["STATUS"] == "3") {
            $return["ERROR"] = "Refunded";
            $return["MESSAGE"] = $request["SUCCESS"][0]["CODE"];
        }
    }
    return $return;
}

?>