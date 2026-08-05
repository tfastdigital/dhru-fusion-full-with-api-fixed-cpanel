<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["qntrangearrayput"] as $input => $input) {
    $rangeid = $input["pricingqntid"];
    $data["start"] = $input["start"];
    $data["end"] = $input["end"];
    updateData("tbl_pricing_qnt", $data, "pricingqntid='" . $rangeid . "'");
    $RETURN["status"] = "success";
    $RETURN["msg"] = "Range Updated";
    return $RETURN;
}

?>