<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["fusion100name"] = "fusion100";
$APIMODULE["fusion100visiblename"] = "Other Script 100";
$APIMODULE["fusion100notes"] = "Server services support added for other script";
function fusion100_activate()
{
    GatewayField("fusion100", "text", "customname", "", "Name", "60", "");
    GatewayField("fusion100", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("fusion100", "text", "username", "", "Username", "30", "");
    GatewayField("fusion100", "text", "apiurl", "http://www.otherfusion.com/", "APi url", "500", "");
}
function fusion100_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $request = $api->action("accountinfo");
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
function fusion100_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $request = $api->action("imeiservicelist");
    if ($request["SUCCESS"]) {
        foreach ($request["SUCCESS"][0]["LIST"] as $Group => $Tools) {
            $return["Group"][$Group]["Name"] = $Group;
            $return["Group"][$Group]["GroupType"] = $Tools["GROUPTYPE"];
            $return["Group"][$Group]["ID"] = $Group;
            foreach ($Tools["SERVICES"] as $Tools => $SERVICES) {
                $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["SERVICEID"];
                if (!$SERVICES["SERVICETYPE"]) {
                    if ($SERVICES["SERVER"] == 2) {
                        $SERVICES["SERVICETYPE"] = "REMOTE";
                    } else {
                        if ($SERVICES["SERVER"] == 1) {
                            $SERVICES["SERVICETYPE"] = "SERVER";
                        } else {
                            $SERVICES["SERVICETYPE"] = "IMEI";
                        }
                    }
                }
                $return["Group"][$Group]["Tool"][$Tools]["ToolType"] = $SERVICES["SERVICETYPE"];
                $return["Group"][$Group]["Tool"][$Tools]["QNT"] = $SERVICES["QNT"];
                $return["Group"][$Group]["Tool"][$Tools]["QntOptions"] = $SERVICES["QNTOPTIONS"];
                $return["Group"][$Group]["Tool"][$Tools]["MinQnt"] = $SERVICES["MINQNT"];
                $return["Group"][$Group]["Tool"][$Tools]["MaxQnt"] = $SERVICES["MAXQNT"];
                $return["Group"][$Group]["Tool"][$Tools]["Custom"] = json_encode($SERVICES["CUSTOM"]);
                $return["Group"][$Group]["Tool"][$Tools]["SERVER"] = $SERVICES["SERVER"];
                $return["Group"][$Group]["Tool"][$Tools]["Name"] = $SERVICES["SERVICENAME"];
                $return["Group"][$Group]["Tool"][$Tools]["Message"] = utf8_decode($SERVICES["INFO"]);
                $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES["CREDIT"];
                $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $SERVICES["TIME"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Network"] = $SERVICES["Requires.Network"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Mobile"] = $SERVICES["Requires.Mobile"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Provider"] = $SERVICES["Requires.Provider"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.PIN"] = $SERVICES["Requires.PIN"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.KBH"] = $SERVICES["Requires.KBH"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.MEP"] = $SERVICES["Requires.MEP"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.PRD"] = $SERVICES["Requires.PRD"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Type"] = $SERVICES["Requires.Type"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Reference"] = $SERVICES["Requires.Reference"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Locks"] = $SERVICES["Requires.Locks"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.SN"] = $SERVICES["Requires.SN"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.SecRO"] = $SERVICES["Requires.SecRO"];
                $return["Group"][$Group]["Tool"][$Tools]["Requires.Custom"] = $SERVICES["Requires.Custom"];
            }
        }
    } else {
        if ($request["ERROR"]) {
            $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    if ($VAL["scripttype"] == "gsmhub") {
        $request2 = $api->action("serverservicelist");
        $requestTypeList = $api->action("serverservicetypelist");
        if ($request2["SUCCESS"]) {
            unset($return["ERROR"]);
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
    } else {
        if ($VAL["scripttype"] == "gsmtool") {
            include_once ROOTDIR . "/modules/apiserver/class/gsmtool.class.php";
            $api = new gsmtool();
            $request2 = $api->action("serverservices", $VAL["apikey"], $VAL["apiurl"], $VAL["username"], []);
            printJson($request2);
            if ($request2[Packages]) {
                foreach ($request2[Packages][Package] as $k => $v) {
                    $Group = $v[Category];
                    if (!trim($Group)) {
                    }
                    $return["Group"][$Group]["Name"] = $Group;
                    $return["Group"][$Group]["GroupType"] = "SERVER";
                    $return["Group"][$Group]["ID"] = $Group;
                    $Tools = $v[PackageId];
                    $return["Group"][$Group]["Tool"][$Tools]["ID"] = $Tools;
                    $return["Group"][$Group]["Tool"][$Tools]["ToolType"] = "SERVER";
                    $return["Group"][$Group]["Tool"][$Tools]["SERVER"] = 1;
                    $return["Group"][$Group]["Tool"][$Tools]["Name"] = $v[PackageTitle];
                    $return["Group"][$Group]["Tool"][$Tools]["Message"] = html_entity_decode(utf8_decode($v[MustRead]));
                    $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $v[PackagePrice];
                    $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $v[TimeTaken];
                }
            }
            printJson($return);
            printJson($request2[Packages]);
        }
    }
    return $return;
}
function fusion100_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mobile"] != "None") {
            echo "<strong>Getting models for : " . $Tool["name"] . "</strong><br/>";
            $api = new DhruFusion();
            $api->apiurl = $VAL["apiurl"];
            $api->username = $VAL["username"];
            $api->apikey = $VAL["apikey"];
            $request = $api->action("modellist", ["ID" => $Tool["id"]]);
            $BID = NULL;
            foreach ($request["SUCCESS"][0]["LIST"] as $gk => $Brand) {
                $BID = $Brand["ID"];
                $return["Brand"][$BID]["ID"] = $BID;
                $return["Brand"][$BID]["Name"] = $Brand["NAME"];
                $MID = NULL;
                foreach ($Brand["MODELS"] as $gk => $Mobile) {
                    $MID = $Mobile["ID"];
                    $return["Brand"][$BID]["Mobile"][$MID]["ID"] = $MID;
                    $return["Brand"][$BID]["Mobile"][$MID]["Name"] = $Mobile["NAME"];
                }
            }
        }
    }
    return $return;
}
function fusion100_provider($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_provider"] != "None") {
            echo "<strong>Getting providers for : " . $Tool["name"] . "</strong><br/>";
            $api = new DhruFusion();
            $api->apiurl = $VAL["apiurl"];
            $api->username = $VAL["username"];
            $api->apikey = $VAL["apikey"];
            $request = $api->action("providerlist", ["ID" => $Tool["id"]]);
            if ($request["SUCCESS"]) {
                $BID = NULL;
                foreach ($request["SUCCESS"][0]["LIST"] as $gk => $Country) {
                    $BID = $Country["ID"];
                    $return["Country"][$BID]["ID"] = $BID;
                    $return["Country"][$BID]["Name"] = $Country["NAME"];
                    $MID = NULL;
                    foreach ($Country["PROVIDERS"] as $gk => $Network) {
                        $MID = $Network["ID"];
                        $return["Country"][$BID]["Network"][$MID]["ID"] = $MID;
                        $return["Country"][$BID]["Network"][$MID]["Name"] = $Network["NAME"];
                    }
                }
            }
            unset($request);
        }
    }
    return $return;
}
function fusion100_assign_networks($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_provider"] != "None") {
            $api = new DhruFusion();
            $api->apiurl = $VAL["apiurl"];
            $api->username = $VAL["username"];
            $api->apikey = $VAL["apikey"];
            $request = $api->action("getimeiservicedetails", ["ID" => $Tool["id"]]);
            if ($request["SUCCESS"]) {
                saveApiAssignnetworks($request["SUCCESS"][0]["LIST"]["assigned_provider"], $VAL["apiservers"], true, $Tool["id"], "in");
            }
            $request = NULL;
        }
    }
}
function fusion100_assign_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mobile"] != "None") {
            echo "<strong>Getting assign models for : " . $Tool["name"] . "</strong><br/>";
            $api = new DhruFusion();
            $api->apiurl = $VAL["apiurl"];
            $api->username = $VAL["username"];
            $api->apikey = $VAL["apikey"];
            $request = $api->action("getimeiservicedetails", ["ID" => $Tool["id"]]);
            if ($request["SUCCESS"]) {
                $__Aassigned = trim($request["SUCCESS"][0]["LIST"]["assigned_model"]);
                saveApiAssignMobiles($__Aassigned, $VAL["apiservers"], true, $Tool["id"], "in");
            }
            unset($request);
            unset($__Aassigned);
        }
    }
}
function fusion100_mep($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $request = $api->action("meplist");
    if ($request["SUCCESS"] && is_array($request["SUCCESS"][0]["LIST"])) {
        foreach ($request["SUCCESS"][0]["LIST"] as $MEP) {
            $return[$MEP["ID"]] = $MEP["NAME"];
        }
    }
    return $return;
}
function fusion100_send($VAL)
{
    global $debug_output;
    global $CustomFieldsMap;
    if ($VAL[scripttype] == "gsmtool" && $VAL[SERVER]) {
        include_once ROOTDIR . "/modules/apiserver/class/gsmtool.class.php";
        $api = new gsmtool();
    } else {
        include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
        $api = new DhruFusion();
    }
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    define("VERSION", $VAL["version"]);
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $api->debug = true;
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
        if ($VAL[scripttype] == "gsmtool" && $VAL[SERVER]) {
            if ($VAL["QNT"]) {
                $sendArr["quantity_G7V7"] = $VAL["QNT"];
                $sendArr["R5C9X7Y9C2J3K9J9P0"] = $VAL["QNT"];
            }
            $request = $api->action("placeserverorder", $VAL["apikey"], $VAL["apiurl"], $VAL["username"], $sendArr);
            if ($request["error"]) {
                $return["ERROR"] = $request["error"][0];
                $return["MESSAGE"] = $request["error"][0];
            } else {
                if ($request["result"][order][0][id]) {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = "";
                    $return["ID"] = $request["result"][order][0][id];
                }
            }
            return $return;
        }
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
    if ($request["SUCCESS"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($request["SUCCESS"][0]["MESSAGE"]);
        $return["ID"] = $request["SUCCESS"][0]["REFERENCEID"];
    } else {
        if ($request["ERROR"]) {
            $return["ERROR"] = json_encode($request);
            $return["MESSAGE"] = $request["ERROR"][0]["MESSAGE"] . nl2br($request["ERROR"][0]["FULL_DESCRIPTION"]);
        }
    }
    return $return;
}
function fusion100_get($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
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
function fusion100_sendfile($VAL)
{
    global $debug_output;
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $sendArr["ID"] = $VAL["API_ID"];
    $sendArr["FILENAME"] = $VAL["FILENAME"];
    $sendArr["FILEDATA"] = $VAL["FILEDATA"];
    $request = $api->action("placefileorder", $sendArr);
    if ($debug_output) {
        echo "<h2>Module Send File Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
        print_r($request);
        echo "<hr />";
    }
    $sendArr = NULL;
    if ($request["SUCCESS"]) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($request["SUCCESS"][0]["MESSAGE"]);
        $return["ID"] = $request["SUCCESS"][0]["REFERENCEID"];
    } else {
        $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
        $return["MESSAGE"] = $request["ERROR"][0]["MESSAGE"] . nl2br($request["ERROR"][0]["FULL_DESCRIPTION"]);
    }
    return $return;
}
function fusion100_getfile($VAL)
{
    global $debug_output;
    include_once ROOTDIR . "/modules/apiserver/class/fusion.class.php";
    define("REQUESTFORMAT", "JSON");
    define("DHRUFUSION_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new DhruFusion();
    $api->apiurl = $VAL["apiurl"];
    $api->username = $VAL["username"];
    $api->apikey = $VAL["apikey"];
    $request = $api->action("getfileorder", ["ID" => $VAL["API_ORDER_ID"]]);
    if ($debug_output) {
        echo "<h2>Module Get File Order Array </h2>";
        print_r($request);
        echo "<hr />";
    }
    if ($request["SUCCESS"]) {
        if ($request["SUCCESS"][0]["STATUS"] == "4") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = htmlspecialchars("Order Found");
            $return["CODES"] = $request["SUCCESS"][0]["CODE"];
        }
        if ($request["SUCCESS"][0]["STATUS"] == "3") {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
        }
    }
    return $return;
}

?>