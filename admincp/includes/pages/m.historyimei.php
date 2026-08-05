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
echo "<h1 class=\"page-title\">IMEI Orders</h1>\n        <ul class=\"navigation\">\n            <li><a href=main4.php?page=imeiorder class=\"btn\">New <span class=\"total blue\">[";
echo $qnew;
echo "]</span></a></li>\n            <li><a href=main4.php?page=acceptsimei class=\"btn\">Accepted <span class=\"total green\">[";
echo $qacc;
echo "]</span></a></li>\n            <li><a href=main4.php?page=verifysimei class=\"btn\">Verification <span class=\"total orange\">[";
echo $qver;
echo "]</span></a></li>\n            <li><a href=main4.php?page=historyimei class=\"btn\">History</a></li>\n        </ul>\n        <div class=\"date-fonts\" id=\"notificationh\"></div> \n   <div class=\"content\">\n   <div class=\"panel\">\n            <h2>Search IMEI Order </h2>\n            <ol>\n                <li class=\"field\">\n                    <label>IMEI:\n                        <input type=text id=user>\n                    </label>\n                </li>\n                \n            </ol>\n        \n        \n            <p><a onclick=\"MgetOrders (document.getElementById('user').value,'#userlisth','false','');\"\n             class=\"btn\" data-rel=back>Search</a></p>\n        </div>\n   </div>\n  \n      \n<div class=\"content\">\n<div class=\"panel\">\n     <h2>IMEI Order history</h2>\n     <div class=\"grid\"  id=\"userlisth\" >\n \n    </div>\n</div>\n</div>    \n    \n \n";

?>