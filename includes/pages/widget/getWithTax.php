<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
require ROOTDIR . "/includes/invoice.fun.php";
require ROOTDIR . "/includes/gateway.fun.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
$gateway = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $gateway);
$amount = preg_replace("/[^0-9.]/i", "", $amount);
$balance = preg_replace("/[^0-9.]/i", "", $balance);
$Gat = mysqli_fetch_assoc(dquery("select `value` from tbl_paymentgateways\nWHERE gateway='" . $gateway . "' and setting='instructions'"));
$Gat["value"] = html_entity_decode($Gat["value"]);
$Gat2 = mysqli_fetch_assoc(dquery("select `value` from tbl_paymentgateways\nWHERE gateway='" . $gateway . "' and setting='info'"));
if ($Gat2["value"]) {
    $Gat["value"] .= html_entity_decode($Gat2["value"]);
}
if ($config["taxenabled"]) {
    $user = mysqli_fetch_assoc(dquery("select state,default_currency,client_group,country from \n     tblUsers where id='" . $_SESSION["uid"] . "'"));
    global $_ClientsDetails;
    $taxrate = getTaxRate(1, $user["state"], $user["country"], $gateway);
    $taxrate2 = getTaxRate(2, $user["state"], $user["country"], $gateway);
    $taxs = "0";
    $taxs2 = "0";
    $taxname = $taxrate["name"];
    $taxname2 = $taxrate2["name"];
    $Groupwise = json_decode($config["addfundpoints"], true);
    if ($taxrate["rate"]) {
        $taxamount = $amount * $taxrate["rate"] / 100;
        $taxs = (string) $taxamount;
        $taxname = $taxrate["name"] . " : " . $taxrate["rate"] . "%";
        $taxrate = $taxrate["rate"];
        $amount1 += round($amount * $taxrate / 100, $precision);
    }
    if ($taxrate2["rate"]) {
        $taxamount = $amount * $taxrate2["rate"] / 100;
        $taxs2 = (string) $taxamount;
        $taxname2 = $taxrate2["name"] . " : " . $taxrate2["rate"] . "%";
        $taxrate2 = $taxrate2["rate"];
        $amount2 += round($amount * $taxrate2 / 100, $precision);
    }
    echo $balance + $amount . "_" . $taxs . "_" . $taxname . "_" . $taxs2 . "_" . $taxname2 . "_" . $config["taxtype"] . "_" . $Gat["value"];
    $user["client_group"] = $user["client_group"] ? $user["client_group"] : "base";
    if (0 < $Groupwise[$user["client_group"]][$user["default_currency"]]) {
        echo "_" . round($amount * $Groupwise[$user["client_group"]][$user["default_currency"]], 4);
    } else {
        echo "_";
    }
    require_once ROOTDIR . "/includes/customfield.fun.inc.php";
    $Custom = getCustomFields($gateway, "0", "0");
    echo "__";
    if ($gateway) {
        foreach ($Custom as $c) {
            echo "            <div class=\"form-group \">\n                <label>";
            echo $c["name"];
            echo "</label>\n                ";
            echo $c["input"];
            echo " <br/>\n                ";
            echo $c["description"];
            echo "            </div>\n            ";
        }
    }
} else {
    echo $amount + $balance . "_0.00_ _0.00_ " . "_" . $Gat["value"];
    echo "_____";
}

?>