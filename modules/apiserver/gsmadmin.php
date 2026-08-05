<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$APIMODULE["gsmadminname"] = "unlockbase";
$APIMODULE["gsmadminvisiblename"] = "gsmadmin.com";
$APIMODULE["gsmadminnotes"] = "This gsmadmin/theunlockclub api (** Only IMEI Field working)";
include_once ROOTDIR . "/modules/apiserver/class/gsmadmin/nusoap.php";
include_once ROOTDIR . "/modules/apiserver/class/gsmadmin/xmlparsefunction.php";
function gsmadmin_activate()
{
    GatewayField("gsmadmin", "text", "apikey", "", "APi KEY", "50", "");
    GatewayField("gsmadmin", "System", "apiurl", "http://gsmadmin.com/gsm/GSMAPI/v1.0/Server/gsmadminapi.php?wsdl", "apiurl", "200", "");
}
function gsmadmin_services($VAL)
{
    $client = new nusoap_client($VAL["apiurl"], true);
    $row_arr = ["apikey" => $VAL["apikey"]];
    $XML = $client->call("GetCarriers", $row_arr);
    if (is_string($XML)) {
        $Data = GsmAdmin::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = "API error : " . htmlspecialchars($Data["Error"][0]["Description"]);
            } else {
                foreach ($Data["Carrier"] as $Service) {
                    $return["Group"][0]["ID"] = "Gsmadmin";
                    $return["Group"][0]["Name"] = "Gsmadmin";
                    $return["Group"][0]["Tool"][$Service["ID"]]["ID"] = $Service["ID"];
                    $return["Group"][0]["Tool"][$Service["ID"]]["Name"] = $Service["Name"];
                    $return["Group"][0]["Tool"][$Service["ID"]]["Credits"] = $Service["Price"];
                }
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    unset($Data);
    unset($XML);
    return $return;
}
function gsmadmin_mobiles__($VAL)
{
    $client = new nusoap_client($VAL["apiurl"], true);
    $row_arr = ["apikey" => $VAL["apikey"]];
    $XML = $client->call("GetCarriers", $row_arr);
    if (is_string($XML)) {
        $Data = GsmAdmin::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = "API error : " . htmlspecialchars($Data["Error"][0]["Description"]);
            } else {
                foreach ($Data["Carrier"] as $Service) {
                    $send_arr = ["apikey" => $VAL["apikey"], "CarrierID" => $Service["ID"]];
                    $XML2 = $client->call("GetDetail", $send_arr);
                    if (is_string($XML2)) {
                        $Data2 = GsmAdmin::ParseXML($XML2);
                        if ($Data2["needTool"] != "false") {
                            $send_arr3 = ["apikey" => $VAL["apikey"], "ToolID" => $Data2["Tool"][0]["ID"]];
                            $XML3 = $client->call("GetToolDetail", $send_arr3);
                            if (is_string($XML3)) {
                                if (14222560 < memory_get_usage()) {
                                    return $return;
                                }
                                $Data3 = GsmAdmin::ParseXML($XML3);
                                if (is_array($Data3["Model"]) && count($Data3["Model"]) < 200) {
                                    echo "Getting mobile list for [" . $Service["ID"] . "] " . $Service["Name"] . " ";
                                    $return["Brand"][$Service["ID"]]["ID"] = $Service["ID"];
                                    $return["Brand"][$Service["ID"]]["Name"] = "Mobiles for " . $Service["Name"];
                                    foreach ($Data3["Model"] as $gk => $Mobile) {
                                        echo ".";
                                        $return["Brand"][$Service["ID"]]["Mobile"][$gk]["ID"] = $Mobile["ID"];
                                        $return["Brand"][$Service["ID"]]["Mobile"][$gk]["Name"] = $Mobile["Name"];
                                    }
                                    echo "Done<br />";
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    unset($Data3);
    unset($Data);
    unset($Data2);
    unset($XML);
    unset($XML2);
    unset($XML3);
    return $return;
}
function gsmadmin_provider__($VAL)
{
    $client = new nusoap_client($VAL["apiurl"], true);
    $row_arr = ["apikey" => $VAL["apikey"]];
    $XML = $client->call("GetCarriers", $row_arr);
    if (is_string($XML)) {
        $Data = GsmAdmin::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = "API error : " . htmlspecialchars($Data["Error"][0]["Description"]);
            } else {
                foreach ($Data["Carrier"] as $Service) {
                    $send_arr = ["apikey" => $VAL["apikey"], "CarrierID" => $Service["ID"]];
                    $XML2 = $client->call("GetDetail", $send_arr);
                    if (is_string($XML2)) {
                        $Data2 = GsmAdmin::ParseXML($XML2);
                        if ($Data2["needTool"] != "false") {
                            $send_arr3 = ["apikey" => $VAL["apikey"], "ToolID" => $Data2["Tool"][0]["ID"]];
                            $XML3 = $client->call("GetToolDetail", $send_arr3);
                            if (is_string($XML3)) {
                                if (14222560 < memory_get_usage()) {
                                    return $return;
                                }
                                $Data3 = GsmAdmin::ParseXML($XML3);
                                if (is_array($Data3["Network"]) && count($Data3["Network"]) < 500) {
                                    echo "Getting Provider list for [" . $Service["ID"] . "] " . $Service["Name"] . " ";
                                    $return["Country"][$Service["ID"]]["ID"] = $Service["ID"];
                                    $return["Country"][$Service["ID"]]["Name"] = "Mobiles for " . $Service["Name"];
                                    foreach ($Data3["Network"] as $gk => $Network) {
                                        echo ".";
                                        $return["Country"][$Service["ID"]]["Network"][$gk]["ID"] = $Network["ID"];
                                        $return["Country"][$Service["ID"]]["Network"][$gk]["Name"] = $Network["Name"];
                                    }
                                    echo "Done<br />";
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $return["ERROR"] = "Could not parse the XML stream";
        }
    } else {
        $return["ERROR"] = "Could not communicate with the api";
    }
    unset($Data3);
    unset($Data);
    unset($Data2);
    unset($XML);
    unset($XML2);
    unset($XML3);
    return $return;
}
function gsmadmin_send($VAL)
{
    $client = new nusoap_client($VAL["apiurl"], true);
    $sendArr["apikey"] = $VAL["apikey"];
    if (is_array($VAL["CUSTOMFIELDS"])) {
        foreach ($VAL["CUSTOMFIELDS"] as $customfield) {
            if ($customfield["name"] == "Provider ID") {
                $ProviderID = $customfield["value"];
            }
        }
    }
    $sendArr["CarrierId"] = $VAL["API_ID"];
    $sendArr["IMEI"] = $VAL["IMEI"];
    $sendArr["Comments"] = "Submitted by Dhru Fusion APi (#" . $VAL["ORDERID"] . ")";
    $sendArr["Mobile"] = $VAL["API_MODEL_ID"];
    $sendArr["Provider"] = $VAL["API_PROVIDER_ID"];
    if ($ProviderID) {
        $sendArr["Provider"] = $ProviderID;
    } else {
        $sendArr["Provider"] = $VAL["API_PROVIDER_ID"];
    }
    $sendArr["PIN"] = $VAL["PIN"];
    $sendArr["KBH"] = $VAL["KBH"];
    $sendArr["MEP"] = $VAL["MEP"];
    $sendArr["PRD"] = $VAL["PRD"];
    $sendArr["Type"] = $VAL["TYPE"];
    $sendArr["Locks"] = $VAL["LOCKS"];
    $XML = $client->call("PlaceOrder", $sendArr);
    if (is_string($XML)) {
        $Data = GsmAdmin::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = "API error : " . htmlspecialchars($Data["Error"][0]["Description"]);
            } else {
                $return["SUCCESS"] = true;
                $return["MESSAGE"] = htmlspecialchars($Data["Success"][0]["Description"]);
                $return["ID"] = $Data["Success"][0]["OrderID"];
            }
        }
    }
    return $return;
}
function gsmadmin_get($VAL)
{
    $client = new nusoap_client($VAL["apiurl"], true);
    $sendArr["apikey"] = $VAL["apikey"];
    $sendArr["orderno"] = $VAL["API_ORDER_ID"];
    $XML = $client->call("GetOrders", $sendArr);
    if (is_string($XML)) {
        $Data = GsmAdmin::ParseXML($XML);
        if (is_array($Data)) {
            if (isset($Data["Error"])) {
                $return["ERROR"] = "API error : " . htmlspecialchars($Data["Error"][0]["Description"]);
            } else {
                if ($Data["OrderDetail"][0]["Status"] == "Delivered") {
                    $return["SUCCESS"] = true;
                    $return["MESSAGE"] = htmlspecialchars($Data["OrderDetail"][0]["UnlockCode"]);
                    $return["CODES"] = $Data["OrderDetail"][0]["UnlockCode"];
                }
                if ($Data["OrderDetail"][0]["Status"] == "Not Found" || $Data["OrderDetail"][0]["Status"] == "Cancel") {
                    $return["ERROR"] = "Not Found";
                    $return["MESSAGE"] = "Not Found";
                }
            }
        }
    }
    return $return;
}

?>