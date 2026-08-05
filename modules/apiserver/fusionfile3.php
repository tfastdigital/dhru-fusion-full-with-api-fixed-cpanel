<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["fusionfile3name"] = "fusionfile3";
$APIMODULE["fusionfile3visiblename"] = "Other Fusion 3 [File Service]";
$APIMODULE["fusionfile3notes"] = "Connect to Other Fusion site with file service api (Reply type text only supported )";
function fusionfile3_activate()
{
    GatewayField("fusionfile3", "System", "servicetype", "file", "servicetype", "60", "");
    GatewayField("fusionfile3", "text", "customname", "", "Name", "60", "");
    GatewayField("fusionfile3", "text", "apikey", "", "APi KEY", "60", "");
    GatewayField("fusionfile3", "text", "username", "", "Username", "30", "");
    GatewayField("fusionfile3", "text", "apiurl", "http://www.otherfusion.com/", "APi url", "500", "");
}
function fusionfile3_accoutinfo($VAL)
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
    if ($request["SUCCESS"]) {
        $return["Account email"] = $request["SUCCESS"][0]["AccoutInfo"]["mail"];
        $return["Credits available"] = $request["SUCCESS"][0]["AccoutInfo"]["credit"];
        $return["currency"] = $request["SUCCESS"][0]["AccoutInfo"]["currency"];
        $return["apiversion"] = $request["apiversion"];
        return $return;
    }
    if ($request["ERROR"]) {
        $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    return $return;
}
function fusionfile3_services($VAL)
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
    $request = $api->action("fileservicelist");
    if ($request["SUCCESS"]) {
        foreach ($request["SUCCESS"][0]["LIST"] as $Group => $Tools) {
            $return["Group"][$Group]["Name"] = $Group;
            $return["Group"][$Group]["ID"] = $Group;
            $return["Group"][$Group]["servicetype"] = "file";
            foreach ($Tools["SERVICES"] as $Tools => $SERVICES) {
                $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["SERVICEID"];
                $return["Group"][$Group]["Tool"][$Tools]["Name"] = $SERVICES["SERVICENAME"];
                $return["Group"][$Group]["Tool"][$Tools]["Message"] = utf8_decode($SERVICES["INFO"]);
                $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES["CREDIT"];
                $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $SERVICES["TIME"];
                $return["Group"][$Group]["Tool"][$Tools]["servicetype"] = "file";
            }
        }
    } else {
        if ($request["ERROR"]) {
            $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
        } else {
            $return["ERROR"] = "Could not communicate with the api";
        }
    }
    return $return;
}
function fusionfile3_sendfile($VAL)
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
        if ($request["ERROR"]) {
            $return["ERROR"] = $request["ERROR"][0]["MESSAGE"];
            $return["MESSAGE"] = $request["ERROR"][0]["MESSAGE"] . nl2br($request["ERROR"][0]["FULL_DESCRIPTION"]);
        }
    }
    return $return;
}
function fusionfile3_getfile($VAL)
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
            $return["ERROR"] = $request["SUCCESS"][0]["CODE"] . " ";
            $return["MESSAGE"] = $request["SUCCESS"][0]["CODE"] . " ";
        }
    }
    return $return;
}

?>