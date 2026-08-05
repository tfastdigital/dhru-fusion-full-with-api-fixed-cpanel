<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["productarrayput"] as $input => $input) {
    unset($DATAR);
    $productid = $input["productid"];
    $autoapi = $input["autoapi"];
    $resetcustomuserprice = $input["resetcustomuserprice"];
    if ($resetcustomuserprice) {
        $conn->query("DELETE FROM tbl_discount_imei WHERE service_id='" . $productid . "'");
    }
    $DATAR["autoapi"] = $input["autoapi"];
    if ($input["time"]) {
        $DATAR["time"] = $input["time"];
    }
    if ($input["purchase_cost"]) {
        $DATAR["purchase_cost"] = $input["purchase_cost"];
    }
    updateData("tbl_services_imei", $DATAR, "id='" . $productid . "'");
    $STATUS = $input["status"];
    $PRICING = $input["pricing"];
    $DefaultIncrease = "";
    if ($input["autoapi"]) {
        $qA = $conn->query("select value from tbl_apiservers\n        WHERE gateway=(select API from tbl_services_imei where id='" . $productid . "')\n        and setting='priceincrease'");
        $DefaultIncrease = $qA->fetch(PDO::FETCH_ASSOC);
        if ($DefaultIncrease["value"]) {
            $DefaultIncrease = json_decode($DefaultIncrease["value"], true);
        }
    }
    $SERVICEARR = [];
    
    foreach ($PRICING as $pricingqntid => $rangedetail) {
        foreach ($rangedetail as $group => $detail) {
            $apiprice = $detail["increment"];
            if ($input["autoapi"]) {
                if ($group == "base" && !$apiprice["value"] && !$DefaultIncrease["base"]["price"]) {
                    $RETURN["msg"] = "Base Price Required - api";
                    $RETURN["status"] = "success";
                    return $RETURN;
                }
                saveAPIIncreament($productid, $group, $apiprice["value"], $apiprice["type"], $pricingqntid);
            } else {
                if ($group == "base") {
                    foreach ($detail["currency"] as $currencyid => $_price) {
                        $price = $_price["price"];
                        if (strlen($price) == 0 && $currencyid == $_SESSION["system_default_currency"]["id"]) {
                            $RETURN["msg"] = "Base Price Required - base";
                            $RETURN["status"] = "error";
                            return $RETURN;
                        }
                        servicePricing($productid, $group, $price, $currencyid, $pricingqntid);
                    }
                } else {
                    if ($group == "retail") {
                        foreach ($detail["currency"] as $currencyid => $_price) {
                            $price = $_price["price"];
                            servicePricing($productid, $group, $price, $currencyid, $pricingqntid);
                        }
                    } else {
                        if ($group == "purchase") {
                            foreach ($detail["currency"] as $currencyid => $_price) {
                                $price = $_price["price"];
                                servicePricing($productid, $group, $price, $currencyid, $pricingqntid);
                            }
                        } else {
                            foreach ($detail["currency"] as $currencyid => $_price) {
                                $price = $_price["price"];
                                servicePricing($productid, $group, $price, $currencyid, $pricingqntid);
                            }
                        }
                    }
                }
            }
        }
    }
}
if ($telegram) {
    sendTelegramFinalize();
    $RETURN["telegram"] = 1;
}
$RETURN["status"] = "success";
$RETURN["msg"] = "Item Updated";
return $RETURN;

?>