<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$database = $conn->query("SELECT database() as db");
$database = $database->fetch(PDO::FETCH_ASSOC);
$result = $conn->query("SHOW TABLE STATUS FROM " . $database["db"]);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $tabled = $row["Name"];
    $RETURN["optimize"][] = $tabled;
}
$RETURN["status"] = "success";

?>