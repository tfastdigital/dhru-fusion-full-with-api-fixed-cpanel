<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "select * from tbl_order_imei where reply like '%RES%' and date>'2018-07-22' and apilogreferenceid!=''";
$q = dquery("select * from tbl_order_imei where reply like '%RES%' and date>'2018-07-22' and apilogreferenceid!=''");
if ($r = mysqli_fetch_assoc($q)) {
    $fileverioncheck = "6.1.0";
} else {
    $api = mysqli_fetch_assoc(dquery("select * from `tbl_apilog` where id='" . $r["apilogreferenceid"] . "'"));
    echo "select * from `tbl_apilog` where id='" . $r["apilogreferenceid"] . "'";
    $code = explode("=", $api["data"]);
    print_r($code);
    echo $code = end($code);
    echo "<br /> " . $r["order_id"];
    exit;
}

?>