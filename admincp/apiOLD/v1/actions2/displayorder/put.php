<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

foreach ($BODY["displayorderarrayput"] as $input => $input) {
    $productid = $input["productid"];
    $displayorder = $input["order"];
    $conn->query("update tbl_services_imei set `sort`='" . $displayorder . "'\n    where id='" . $productid . "'");
}
$RETURN["status"] = "success";
$RETURN["msg"] = "Item Updated";

?>