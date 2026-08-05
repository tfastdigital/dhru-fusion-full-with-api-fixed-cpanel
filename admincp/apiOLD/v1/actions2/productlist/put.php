<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["productlistarrayput"] as $key => $input) {
    $productgroupid = $input["productgroupid"];
    foreach ($input as $productid => $prodetail) {
        $STATUS = $prodetail["status"];
        $PRICING = $prodetail["pricing"];
        $DATAR = NULL;
        $DATAR["purchase_cost"] = $prodetail["purchase_cost"];
        $DATAR["time"] = $prodetail["time"];
        updateData("tbl_services_imei", $DATAR, "id='" . $productid . "'");
        $SERVICEARR = [];
        foreach ($PRICING as $pricingqntid => $rangedetail) {
            foreach ($rangedetail as $group => $detail) {
                $apiprice = $detail["increment"];
                if ($input["autoapi"]) {
                    if ($group == "base" && !$apiprice["value"]) {
                        $RETURN["msg"] = "Base Price Required - api";
                        $RETURN["status"] = "error";
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
    $RETURN["status"] = "success";
    $RETURN["msg"] = "Product Group Items Updated";
    if ($telegram) {
        sendTelegramFinalize();
        $RETURN["telegram"] = 1;
    }
    return $RETURN;
}

?>