<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["itemgrouparraypost"] as $input => $input) {
    $RETURN = createItemGroup($input);
}
function createItemGroup($DATA)
{
    global $conn;
    global $remote_ip;
    $data["itemgroupname"] = $DATA["itemgroupname"];
    $data["itemgroupmid"] = $DATA["itemgroupmid"];
    $id = insertData("tblItemsGroups", $data);
    $data = NULL;
    $_RETURN["status"] = "success";
    $_RETURN["msg"] = "Item Group #" . $id;
    return $_RETURN;
}

?>