<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n  \n    <div class=\"date-fonts\">\n          <span class=\"large\">New IMEI Orders</span>\n      <div class=\"cb\"></div>\n    </div>\n    \n     <div class=\"indices\" >\n   ";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$imeiServiceDetails = getIMEIServices("", "", "", true, true, "", "", "", "", "", "", "", 9999);
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE `user_can_c`='0' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            echo "      \n       <div class=\"indice-tab\">\n        <a href=\"main3.php?page=newimeiorder&id=";
            echo $keys["id"];
            echo "\">\n          <ul>\n            <li class=\"index-text\">";
            echo $keys["service_name"];
            echo " [";
            echo $cnt;
            echo "]</span></li>\n            <li class=\"go-btn\"><img src=\"templates/mobile/images/go-btn.gif\" alt=\"Click\" /></li>\n          </ul>\n          <div class=\"cb\"></div>\n        </a>\n      </div>\n                ";
        }
    }
}
echo "   \n\n      \n\n    \n    \n   \n\n      </div>   \n      \n                  \n\n\n    \n    \n  \n   \n   \n ";

?>