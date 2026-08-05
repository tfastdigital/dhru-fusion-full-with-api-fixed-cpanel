<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["itemgrouparrayput"] as $key => $input) {
    $itemid = $input["itemgroupid"];
    $data["itemgroupname"] = $input["itemgroupname"];
    $data["itemgroupmid"] = $input["itemgroupmid"];
    updateData("tblItemsGroups", $data, "itemgroupid='" . $itemid . "'");
    $RETURN["status"] = "success";
    $RETURN["msg"] = "Item Group Updated";
    return $RETURN;
}

?>