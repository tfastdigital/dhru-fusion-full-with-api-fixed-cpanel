<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function getQntRange($start = "", $limit = "")
{
    global $conn;
    if (!$start) {
        $start = 0;
    }
    if (!$limit) {
        $limit = 100;
    }
    $q = $conn->query("SELECT  * FROM tbl_pricing_qnt LIMIT " . $start . "," . $limit);
    while ($row = $q->fetch(PDO::FETCH_ASSOC)) {
        $row["display"] = $row["start"] . "-" . $row["end"];
        $RETURN[] = $row;
    }
    return $RETURN;
}

?>