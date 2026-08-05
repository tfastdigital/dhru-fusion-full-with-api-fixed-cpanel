<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$_include = "qntrange";
include_once "_autoload.php";
function init()
{
    global $conn;
    global $config;
    $RETURN["itemtypes"] = itemTypes();
    $RETURN["currencies"] = getCurrencies();
    $RETURN["systemcurrencyid"] = $_SESSION["system_default_currency"]["id"];
    $RETURN["range"] = getQntRange();
    $RETURN["config"]["precision"] = $config["precision"];
    $RETURN["config"]["defaultcountry"] = $config["DefaultCountry"];
    $RETURN["config"]["admintheme"] = $_SESSION["admintheme"];
    $RECURRING["pricingmon"] = ["text" => "Monthly"];
    $RECURRING["pricingqua"] = ["text" => "Quarterly"];
    $RECURRING["pricingsemi"] = ["text" => "Semi Annually"];
    $RECURRING["pricingann"] = ["text" => "Annually"];
    $RECURRING["pricingbia"] = ["text" => "Bi-Annually"];
    $RECURRING["pricingtria"] = ["text" => "Tri-Annually"];
    $RECURRING["pricingdays"] = ["text" => "Custom Days"];
    $RETURN["recurring"] = $RECURRING;
    $q = $conn->query("select id,group_name,server from tbl_imei_group");
    while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
        $r["group_name"] = html_entity_decode($r["group_name"]);
        $RETURN["productgroup"][] = $r;
    }
    $RETURN["clientgroup"] = getClientGroup();
    return $RETURN;
}

?>