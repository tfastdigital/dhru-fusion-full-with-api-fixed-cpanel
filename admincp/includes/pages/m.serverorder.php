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
$qnew = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='0'"));
$qacc = mysqli_num_rows(dquery("select order_id from tbl_order_server where user_can_c='1'"));
$qver = mysqli_num_rows(dquery("select order_id from tbl_order_server where `user_can_c`='4' AND `verified`='1'"));
echo "  <h1 class=\"page-title\">Server Orders</h1>\n        <ul class=\"navigation\">\n            <li><a href=\"main4.php?page=serverorder\" class=\"btn\">New <span class=\"total blue\">[";
echo $qnew;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=acceptsserver\" class=\"btn\">Accepted <span class=\"total green\">[";
echo $qacc;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=verifysserver\" class=\"btn\">Verification <span class=\"total orange\">[";
echo $qver;
echo "]</span></a></li>\n            <li><a href=\"main4.php?page=historyserver\" class=\"btn\">History</a></li>\n        </ul>\n\n  <div class=\"panel\">\n            <h2>New Server Orders</h2>\n            <ul class=\"list\" >\n   ";
include_once ROOTDIR . "/includes/serverservices.fun.php";
$imeiServiceDetails = getServerServices("", "", "", true, true, "", "", "", "", "", "", "", 9999);
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_server` WHERE `user_can_c`='0' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            echo " <li  ><a href=\"main4.php?page=newserverorder&id=";
            echo $keys["id"];
            echo "\" >";
            echo $keys["service_name"];
            echo " <span class=\"total black\">[";
            echo $cnt;
            echo "]</span></a></li>\n ";
        }
    }
}
echo "                          </ul>\n  </div>\n";

?>