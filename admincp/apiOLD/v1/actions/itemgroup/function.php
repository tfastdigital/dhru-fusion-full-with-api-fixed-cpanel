<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getItemGroup($start = "", $limit = "")
{
    global $conn;
    global $config;
    if (!$start) {
        $start = 0;
    }
    if (!$limit) {
        $limit = 100;
    }
    $q = $conn->query("SELECT  * FROM tblItemsGroups where itemgroupmid=0 LIMIT " . $start . "," . $limit);
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        if ($res = GroupData($row["itemgroupid"])) {
            $row["sub"] = $res;
        }
        $RETURN[$row["itemgroupid"]] = $row;
    }
    return $RETURN;
}
function GroupData($groupmasterid)
{
    global $conn;
    $q = $conn->query("select * from tblItemsGroups WHERE itemgroupmid='" . $groupmasterid . "'");
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        if ($res = GroupData($row["itemgroupid"])) {
            $row["sub"] = $res;
        }
        $RETURN[$row["itemgroupid"]] = $row;
    }
    return $RETURN;
}

?>