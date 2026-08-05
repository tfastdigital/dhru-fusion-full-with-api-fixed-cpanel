<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["imeicodescoukname"] = "imeicodescouk";
$APIMODULE["imeicodescoukvisiblename"] = "imeicodes.co.uk";
$APIMODULE["imeicodescouknotes"] = "Phone #: +44 8718724557 <br />\nEmail: sales@fonefunshop.co.uk<br />\nGtalk: mick@fonefun.net<br />\nMSN: sales@fonefunshop.co.uk<br />\nSkype: fonefunshop<br />";
function imeicodescouk_activate()
{
    GatewayField("imeicodescouk", "text", "password", "", "Password", "60", "");
    GatewayField("imeicodescouk", "text", "username", "", "Username", "60", "");
    GatewayField("imeicodescouk", "System", "apiurl", "http://www.imeicodes.co.uk/api/v1/api.class.php", "APi url", "500", "");
}
function imeicodescouk_accoutinfo($VAL)
{
}
function imeicodescouk_services($VAL)
{
    global $servicereq;
    $servicereq = NULL;
    include_once ROOTDIR . "/modules/apiserver/class/imeicodescouk.class.php";
    $service = new imeiCodes();
    $service->user_name = $VAL["username"];
    $service->password = $VAL["password"];
    $service->buildGetServices();
    $reply = $service->fetchcodes($service->api);
    if ($reply["data"]["response"]["service"]) {
        $servicereq = $reply["data"]["response"]["service"];
        foreach ($reply["data"]["response"]["service"] as $Tools => $SERVICES) {
            $return["Group"][$Group]["Name"] = "Imeicodes.co.uk";
            $return["Group"][$Group]["ID"] = "1";
            $return["Group"][$Group]["Tool"][$Tools]["ID"] = $SERVICES["id"];
            $return["Group"][$Group]["Tool"][$Tools]["Name"] = $SERVICES["name"];
            $return["Group"][$Group]["Tool"][$Tools]["Message"] = $SERVICES["descr"];
            $return["Group"][$Group]["Tool"][$Tools]["Credits"] = $SERVICES["lpu"];
            $return["Group"][$Group]["Tool"][$Tools]["Delivery.Unit"] = $SERVICES["del_time"];
            $return["Group"][$Group]["Tool"][$Tools]["Requires.Network"] = $SERVICES["req_extrada"]["name"] == "Network" ? "Required" : "None";
            $return["Group"][$Group]["Tool"][$Tools]["Requires.Provider"] = $SERVICES["req_extrada"]["name"] == "Network" ? "Required" : "None";
            $return["Group"][$Group]["Tool"][$Tools]["Requires.KBH"] = $SERVICES["req_extrada"]["name"] == "KBH" ? "Required" : "None";
            $return["Group"][$Group]["Tool"][$Tools]["Requires.MEP"] = $SERVICES["req_extrada"]["name"] == "mep" ? "Required" : "None";
        }
    } else {
        $return["ERROR"] = $reply["data"]["response"]["error"]["msg"];
    }
    return $return;
}
function imeicodescouk_provider($VAL)
{
    global $servicereq;
    foreach ($VAL["services"] as $Tool) {
        if ($Tool["requires_provider"] != "None") {
            foreach ($servicereq as $V) {
                if ($V["id"] == $Tool["id"] && $V["req_extrada"]["options"]) {
                    $BID = "1";
                    $return["Country"][$BID]["ID"] = $BID;
                    $return["Country"][$BID]["Name"] = $V["name"];
                    $MID = NULL;
                    foreach ($V["req_extrada"]["options"] as $gk => $Network) {
                        $MID = $Network["data_to_submit"];
                        $return["Country"][$BID]["Network"][$MID]["ID"] = $MID;
                        $return["Country"][$BID]["Network"][$MID]["Name"] = $Network["descr"];
                    }
                }
            }
        }
    }
    return $return;
}
function imeicodescouk_send($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/imeicodescouk.class.php";
    $product["plugin_data"] = $VAL["API_ID"];
    $request["imei"] = $VAL["IMEI"];
    $service = new imeiCodes();
    $service->user_name = $VAL["username"];
    $service->password = $VAL["password"];
    $service->product = $product;
    $service->request = $request;
    $service->buildSubmit();
    $reply = $service->fetchcodes($service->api);
    if ($reply["data"]["response"]["imei"]["status"] == "ready") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($Data["Success"]);
        $return["ID"] = $VAL["IMEI"];
        $return["CODES"] = $reply["data"]["response"]["imei"]["codes"];
    } else {
        if ($reply["data"]["response"]["imei"]["status"] == "pending") {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Submited";
            $return["ID"] = $reply["data"]["response"]["imei"]["order_id"];
        } else {
            $return["ERROR"] = $reply["data"]["response"]["imei"]["status"];
            $return["MESSAGE"] = "ERROR 303";
        }
    }
    return $return;
}
function imeicodescouk_get($VAL)
{
    include_once ROOTDIR . "/modules/apiserver/class/imeicodescouk.class.php";
    $service = new imeiCodes();
    $service->user_name = $VAL["username"];
    $service->password = $VAL["password"];
    $service->imeiList[0] = $VAL["IMEI"];
    $service->buildFetch();
    $reply = $service->fetchcodes($service->api);
    if ($reply["data"]["response"]["imei"]["status"] == "ready") {
        $return["SUCCESS"] = true;
        $return["MESSAGE"] = htmlspecialchars($Data["Success"]);
        $return["ID"] = $VAL["IMEI"];
        $return["CODES"] = $reply["data"]["response"]["imei"]["codes"];
    } else {
        if ($reply["data"]["response"]["imei"]["status"] == "not found") {
            $return["ERROR"] = "Not Found";
            $return["MESSAGE"] = "Not Found";
        }
    }
    return $return;
}

?>