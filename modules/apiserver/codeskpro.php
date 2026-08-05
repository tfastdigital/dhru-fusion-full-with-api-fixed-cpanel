<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["codeskproname"] = "codeskpro";
$APIMODULE["codeskprovisiblename"] = "Codeskpro.net";
$APIMODULE["codeskpronotes"] = "";
function codeskpro_activate()
{
    GatewayField("codeskpro", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("codeskpro", "text", "username", "", "Username", "30", "");
    GatewayField("codeskpro", "System", "apiurl", "http://www.codeskpro.net/", "APi url", "500", "");
}
function codeskpro_accoutinfo($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new CodeskPro();
    $request = $api->action("ACCOUNTINFO");
    if ($request["RET"] == 0) {
        $return["Account email"] = $request["USERNAME"];
        $return["Account email"] = $request["USERNAME"];
        $return["Credits available"] = $request["USERCRED"];
        return $return;
    }
    $return["ERROR"] = "Could not communicate with the api";
    return $return;
}
function codeskpro_services($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new CodeskPro();
    $request = $api->action("SERVICELIST");
    if ($request["RET"] == 0) {
        foreach ($request["PRODUCTS"] as $SERVICES) {
            $Group = "Codesk - Family";
            $return["Group"][$Group]["Name"] = $Group;
            $return["Group"][$Group]["ID"] = $Group;
            $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["ID"] = $SERVICES["IDPROD"];
            $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Name"] = $SERVICES["PRODNAME"];
            $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Message"] = "";
            $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Credits"] = $SERVICES["PRODPRICE"];
            $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Delivery.Unit"] = $SERVICES["PRODTIME"];
            if (isset($SERVICES["FIELDS"]["NETWORK"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Network"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Network"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["MODEL"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Mobile"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Mobile"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["PIN"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.PIN"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.PIN"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["DATAFIELD"])) {
                if (strtoupper($SERVICES["FIELDS"]["DATAFIELD"]["LBL"]) == strtoupper("SecRo")) {
                    $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.KBH"] = "Required";
                } else {
                    $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.KBH"] = "None";
                }
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.KBH"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["MEP-PRD"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.MEP"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.MEP"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["DATAFIELD"])) {
                if (strtoupper($SERVICES["FIELDS"]["DATAFIELD"]["LBL"]) == strtoupper("Provider")) {
                    $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.PRD"] = "Required";
                } else {
                    $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.PRD"] = "None";
                }
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.PRD"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["Type"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Type"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Type"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["Reference"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Reference"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Reference"] = "None";
            }
            if (isset($SERVICES["FIELDS"]["Locks"])) {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Locks"] = "Required";
            } else {
                $return["Group"][$Group]["Tool"][$SERVICES["IDPROD"]]["Requires.Locks"] = "None";
            }
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function codeskpro_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mobile"] != "None") {
            echo "<strong>Getting models for : " . $Tool["name"] . "</strong><br/>";
            $api = new CodeskPro();
            $request = $api->action("ITEMLIST", ["LISTNAME" => "MODEL", "SERVICEID" => $Tool["id"]]);
            foreach ($request["LIST"] as $Bk => $Brand) {
                $return["Brand"][$Bk]["ID"] = $Brand["VAL"];
                $return["Brand"][$Bk]["Name"] = $Brand["LBL"];
                foreach ($Brand["ITEMS"] as $Mk => $Mobile) {
                    $return["Brand"][$Bk]["Mobile"][$Mk]["ID"] = $Mobile["ID"];
                    $return["Brand"][$Bk]["Mobile"][$Mk]["Name"] = $Mobile["LBL"];
                }
            }
        }
    }
    return $return;
}
function codeskpro_provider($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mobile"] != "None") {
            echo "<strong>Getting models for : " . $Tool["name"] . "</strong><br/>";
            $api = new CodeskPro();
            $request = $api->action("ITEMLIST", ["LISTNAME" => "NETWORK", "SERVICEID" => $Tool["id"]]);
            foreach ($request["LIST"] as $Bk => $Brand) {
                $return["Brand"][$Bk]["ID"] = $Brand["VAL"];
                $return["Brand"][$Bk]["Name"] = $Brand["LBL"];
                foreach ($Brand["ITEMS"] as $Mk => $Mobile) {
                    $return["Brand"][$Bk]["Mobile"][$Mk]["ID"] = $Mobile["ID"];
                    $return["Brand"][$Bk]["Mobile"][$Mk]["Name"] = $Mobile["LBL"];
                }
            }
        }
    }
    return $return;
}
function codeskpro_assign_networks($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_provider"] != "None") {
            $api = new CodeskPro();
            $request = $api->action("ITEMLIST", ["LISTNAME" => "MODEL", "SERVICEID" => $Tool["id"]]);
            foreach ($request["LIST"] as $Bk => $Brand) {
                saveApiAssignMobiles($Brand["ITEMS"], $VAL["apiservers"], true, $Tool["id"], "arry");
            }
            unset($request);
        }
    }
}
function codeskpro_assign_mobiles($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mobile"] != "None") {
            echo "<strong>Getting assign models for : " . $Tool["name"] . "</strong><br/>";
            $api = new CodeskPro();
            $request = $api->action("ITEMLIST", ["LISTNAME" => "MODEL", "SERVICEID" => $Tool["id"]]);
            foreach ($request["LIST"] as $Bk => $Brand) {
                saveApiAssignMobiles($Brand["ITEMS"], $VAL["apiservers"], true, $Tool["id"], "arry");
            }
            unset($request);
        }
    }
}
function codeskpro_mep($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_mep"] != "None") {
            echo "<strong>Getting MEP's for : " . $Tool["name"] . "</strong><br/>";
            $api = new CodeskPro();
            $request = $api->action("ITEMLIST", ["LISTNAME" => "MEP-PRD", "SERVICEID" => $Tool["id"]]);
            foreach ($request["LIST"] as $Mk => $MEP) {
                $return[$MEP["VAL"]] = $MEP["LBL"];
            }
        }
    }
    return $return;
}
function codeskpro_send($VAL)
{
    global $debug_output;
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new CodeskPro();
    $sendArr["SERVICEID"] = $VAL["API_ID"];
    $sendArr["IMEI"] = $VAL["IMEI"];
    $sendArr["MODEL"] = $VAL["API_MODEL_ID"];
    $sendArr["PROVIDER"] = $VAL["API_PROVIDER_ID"];
    $sendArr["NETWORK"] = $VAL["API_PROVIDER_ID"];
    $sendArr["MEP"] = $VAL["API_MEP_ID"];
    if ($VAL["PIN"]) {
        $sendArr["DATAFIELD"] = $VAL["PIN"];
    }
    if ($VAL["KBH"]) {
        $sendArr["DATAFIELD"] = $VAL["KBH"];
    }
    if ($VAL["PRD"]) {
        $sendArr["DATAFIELD"] = $VAL["PRD"];
    }
    $request = $api->action("PLACEORDER", $sendArr);
    if ($debug_output) {
        echo "<h2>Module Send Order Array </h2>";
        print_r($sendArr);
        echo "<hr />";
        print_r($request);
        echo "<hr />";
    }
    $sendArr = NULL;
    if ($request["RET"] == 0) {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars("Credit left: " . $request["USERCRED"]);
        $return["ID"] = $request["IDORDER"];
    } else {
        $return["ERROR"] = $request["RET"];
        $return["MESSAGE"] = $api->_errors[$request["RET"]];
    }
    return $return;
}
function codeskpro_get($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/codeskpro.class.php";
    define("REQUESTFORMAT", "JSON");
    define("CODESK_URL", $VAL["apiurl"]);
    define("USERNAME", $VAL["username"]);
    define("API_ACCESS_KEY", $VAL["apikey"]);
    $api = new CodeskPro();
    $request = $api->action("ORDERINFO", ["ORDERID" => $VAL["API_ORDER_ID"]]);
    if ($request["RET"] == 0 && $request["ORDER_" . $VAL["API_ORDER_ID"]]["ORDSTATUS"] == "2") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars("Order Found");
        $return["CODES"] = $request["ORDER_" . $VAL["API_ORDER_ID"]]["RESULTTXT"];
    }
    return $return;
}

?>