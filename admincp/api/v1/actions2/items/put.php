<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (1==1) {
    $itemid = $input["itemid"];
    $data["itemname"] = $input["itemname"];
    $data["itemtype"] = $input["itemtype"];
    $data["itemgroupid"] = $input["itemgroupid"];
    $data["itemdescription"] = $input["itemdescription"];
    $data["itemstatus"] = $input["itemstatus"];
    $data["itemdisplayorder"] = $input["itemdisplayorder"];
    $Config = [];
    foreach ($input["itemconfig"] as $con) {
        $Config[$con["input"]] = $con["value"];
    }
    $data["itemconfig"] = json_encode($Config);
    $data["pricingtype"] = $input["pricingtype"];
    $data["itemmasterid"] = $input["itemmasterid"];
    $data["itemupgradewith"] = $input["itemupgradewith"];
    $data["allowmultipleorders"] = $input["allowmultipleorders"];
    updateData("tblItems", $data, "itemid='" . $itemid . "'");
    $RETURN["status"] = "success";
    $RETURN["msg"] = "Item Updated";
    return $RETURN;
}

?>