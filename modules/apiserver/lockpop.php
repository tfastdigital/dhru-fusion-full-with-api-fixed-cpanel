<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

error_reporting(0);
$APIMODULE["lockpopname"] = "lockpop";
$APIMODULE["lockpopvisiblename"] = "LOCKPOP";
$APIMODULE["lockpopnotes"] = "This lockpop api";
include_once ROOTDIR . "/modules/apiserver/class/lockpop.class.php";
function lockpop_activate()
{
    GatewayField("lockpop", "text", "apikey", "", "APi KEY", "100", "");
}
function lockpop_services($VAL)
{
    $request = "<?xml version=\"1.0\"?><OptionsRequest><ResellerKey>" . $VAL["apikey"] . "</ResellerKey></OptionsRequest>";
    $url = "http://www.lockpop.com/api/Options.ashx";
    if (($response = getLockpop($request, $url)) && $response->Options->OptionDescription) {
        foreach ($response->Options->OptionDescription as $Tool) {
            $return["Group"][0]["ID"] = "LOCKPOP";
            $return["Group"][0]["Name"] = "LOCKPOP";
            $return["Group"][0]["Tool"][(string) $Tool->OptionId]["ID"] = (string) $Tool->OptionId;
            $return["Group"][0]["Tool"][(string) $Tool->OptionId]["Name"] = (string) $Tool->Name;
            $return["Group"][0]["Tool"][(string) $Tool->OptionId]["Message"] = (string) $Tool->Description;
            $return["Group"][0]["Tool"][(string) $Tool->OptionId]["Credits"] = (string) $Tool->Price;
        }
    }
    return $return;
}
function lockpop_send($VAL)
{
    $request = "<?xml version=\"1.0\"?><OrderRequest><ResellerKey>" . $VAL["apikey"] . "</ResellerKey><OptionId>" . $VAL["API_ID"] . "</OptionId><Imei>" . $VAL["IMEI"] . "</Imei></OrderRequest>";
    $url = "http://www.lockpop.com/api/Order.ashx";
    if ($response = getLockpop($request, $url)) {
        if ($debug_output) {
            echo "<h2>Module _send Response</h2>";
            print_r($response);
            echo "<hr />";
        }
        if ($response->OrderId) {
            $return["SUCCESS"] = true;
            $return["MESSAGE"] = "Send Success";
            $return["ID"] = (string) $response->OrderId;
            if ((string) $response->Code != "") {
                $return["CODES"] = $response->Code;
            }
        } else {
            $return["ERROR"] = "Sending Error";
            $return["MESSAGE"] = "ERROR 029";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
        $return["MESSAGE"] = "ERROR 030";
    }
    return $return;
}
function lockpop_get($VAL)
{
    if ($VAL["API_ORDER_ID"] == "" || $VAL["API_ORDER_ID"] == 0) {
        $VAL["API_ORDER_ID"] = $VAL["IMEI"];
    }
    if ($VAL["API_ORDER_ID"] != 0) {
        $request = "<?xml version=\"1.0\"?><OrderHistoryRequest><ResellerKey>" . $VAL["apikey"] . "</ResellerKey><OrderId>" . $VAL["API_ORDER_ID"] . "</OrderId></OrderHistoryRequest>";
        $url = "http://www.lockpop.com/api/OrderHistory.ashx";
        if ($response = getLockpop($request, $url)) {
            $orderstatus = (string) $response->Orders->OrderDescription->Status;
            if ($orderstatus == "7") {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = "code found";
                $return["CODES"] = (string) $response->Orders->OrderDescription->Code;
            } else {
                if ($orderstatus == "-1") {
                    $return["ERROR"] = "- Rejected -";
                    $return["MESSAGE"] = "- Rejected -";
                } else {
                    if ($orderstatus == "6") {
                        $return["ERROR"] = "- Cancelled -";
                        $return["MESSAGE"] = "- Cancelled -";
                    } else {
                        if ($orderstatus == "8") {
                            $return["ERROR"] = "- Not Found -";
                            $return["MESSAGE"] = "- Not Found -";
                        }
                    }
                }
            }
        }
    } else {
        $return["ERROR"] = "- No Order ID -";
        $return["MESSAGE"] = "- No Order ID -";
    }
    return $return;
}

?>