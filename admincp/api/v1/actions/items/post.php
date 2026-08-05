<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["itemarraypost"] as $key => $input) {
    $RETURN = createItem($input);
}
function createItem($DATA)
{
    global $conn;
    global $remote_ip;
    $data["itemname"] = $DATA["itemname"];
    $data["itemtype"] = $DATA["itemtype"];
    $data["itemgroupid"] = $DATA["itemgroupid"];
    $data["itemdescription"] = $DATA["itemdescription"];
    $data["itemstatus"] = $DATA["itemstatus"];
    $data["itemdisplayorder"] = $DATA["itemdisplayorder"];
    $Config = [];
    foreach ($DATA["itemconfig"] as $con) {
        $Config[$con["input"]] = $con["value"];
    }
    $data["itemconfig"] = json_encode($Config);
    $data["pricingtype"] = $DATA["pricingtype"];
    $data["itemmasterid"] = $DATA["itemmasterid"];
    $data["itemupgradewith"] = $DATA["itemupgradewith"];
    $data["allowmultipleorders"] = $DATA["allowmultipleorders"];
    $id = insertData("tblItems", $data);
    if ($DATA["pricing"]) {
        $PRICE = $DATA["pricing"];
        foreach ($PRICE as $pricingtype => $PRICING) {
            foreach ($PRICING["currency"] as $currencyid => $curdetail) {
                $CurrencyWisePrice[$currencyid][$pricingtype]["price"] = $curdetail["price"];
                $CurrencyWisePrice[$currencyid][$pricingtype]["templateid"] = $PRICING["pricingtemplateid"];
            }
        }
    }
    foreach ($CurrencyWisePrice as $currencyid => $pricedet) {
        foreach ($pricedet as $pricingtype => $det) {
            $data = NULL;
            $data["itemid"] = $id;
            $data["pricingtemplateid"] = $det["templateid"];
            $data[$pricingtype] = $det["price"];
            $data["currencyid"] = $currencyid;
            insertData("tblItemPrice", $data);
        }
    }
    $data = NULL;
    $_RETURN["status"] = "success";
    $_RETURN["msg"] = "Item Created #" . $id;
    return $_RETURN;
}

?>