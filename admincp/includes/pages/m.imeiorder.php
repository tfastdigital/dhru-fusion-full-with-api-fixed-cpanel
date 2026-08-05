<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$qnew = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='0'"));
$qacc = mysqli_num_rows(dquery("select order_id from tbl_order_imei where user_can_c='1'"));
$qver = mysqli_num_rows(dquery("select order_id from tbl_order_imei where `user_can_c`='4' AND `verified`='1'"));
echo "<h1 class=\"page-title\">IMEI Orders</h1>\n        <ul class=\"navigation\">\n            <li><a href=\"main4.php?page=imeiorder\" class=\"btn\">New <span class=\"total blue\">[";
echo $qnew;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=acceptsimei\" class=\"btn\">Accepted <span class=\"total green\">[";
echo $qacc;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=verifysimei\" class=\"btn\">Verification <span class=\"total orange\">[";
echo $qver;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=historyimei\" class=\"btn\">History</a></li>\n        </ul>\n        \n  <div class=\"panel\">\n            <h2>New IMEI Orders</h2>\n            <ul class=\"list\" >\n   ";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$imeiServiceDetails = getIMEIServices("", "", "", true, true, "", "", "", "", "", "", "", 9999);
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE `user_can_c`='0' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            echo " <li  ><a href=\"main4.php?page=newimeiorder&id=";
            echo $keys["id"];
            echo "\" > ";
            echo $keys["service_name"];
            echo " <span class=\"total black\">[";
            echo $cnt;
            echo "]</span></a></li>\n ";
        }
    }
}
echo "                            \n                          </ul>\n  </div>\n";

?>