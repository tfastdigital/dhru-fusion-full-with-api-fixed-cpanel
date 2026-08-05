<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getItems($start = "", $limit = "")
{
    global $conn;
    global $config;
    if (!$start) {
        $start = 0;
    }
    if (!$limit) {
        $limit = 100;
    }
    $q = $conn->query("SELECT  * FROM tblItems LIMIT " . $start . "," . $limit);
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $itemconfig = json_decode($row["itemconfig"], true);
        $itemtype = itemTypes();
        $row["itemconfig"] = $itemtype[$row["itemtype"]]["config"];
        foreach ($itemconfig as $key => $iconfig) {
            foreach ($row["itemconfig"] as $k => $cons) {
                if ($cons["input"] == $key) {
                    $row["itemconfig"][$k]["value"] = $itemconfig[$key];
                }
            }
        }
        $RETURN[$row["itemid"]] = $row;
        $q1 = $conn->query("select * from tblItemPrice where itemid='" . $row["itemid"] . "'");
        while ($row1 = $q1->fetch(PDO::FETCH_ASSOC)) {
            $RETURN[$row["itemid"]]["pricing"][] = $row1;
        }
    }
    return $RETURN;
}

?>