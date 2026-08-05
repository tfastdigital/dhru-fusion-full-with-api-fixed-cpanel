<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 111;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/imeiservices.fun.php";
$imeiServiceDetails = getIMEIServices("", "", "", true, true);
echo "<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"newimeiorder\" name=\"\" method=\"post\">\n\n\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>\n\n                <th>";
echo $LNG["servicename"];
echo "</th>\n                <th>";
echo $LNG["order"];
echo " </th>\n                <th>";
echo $LNG["apicon"];
echo " </th>\n                <th>";
echo $LNG["action"];
echo " </th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    $show = false;
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE `user_can_c`='1' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            $show = true;
        }
    }
    if ($show) {
        echo "<tr><td colspan=4 cols=4><strong>" . $group . "</strong></td></tr>";
    }
    foreach ($imeiServiceDetails[$group] as $keys) {
        $cnt = mysqli_num_rows(dquery("SELECT `order_id` FROM `tbl_order_imei` WHERE `user_can_c`='1' AND `service_id`='" . $keys["id"] . "'"));
        if ($cnt) {
            echo "<tr>\n<td>";
            echo $keys["service_name"];
            echo "</td>\n<td>";
            echo $cnt;
            echo "</td>\n<td>";
            if ($keys["API"] != "") {
                $api = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_apiservers` WHERE `gateway`='" . $keys["API"] . "' AND `setting`='name'"));
                echo $api["value"];
            } else {
                echo "No";
            }
            echo "</td> \n<td> \n";
            if ($keys["API"] != "") {
                echo "<a onclick=\"if(confirm('This service is now connected to API. Do you want to Continue')) { getContect('#tab11','main2.php?page=viewimeiorder.accepted','";
                echo $keys["id"];
                echo "','','#tabcontent',true,'#main_loader'); }\"  >";
                echo $LNG["vieworder"];
                echo "</a></td>    \n    ";
            } else {
                echo "<a onclick=\"getContect('#tab11','main2.php?page=viewimeiorder.accepted','";
                echo $keys["id"];
                echo "','','#tabcontent',true,'#main_loader');\"  >";
                echo $LNG["vieworder"];
                echo "</a></td>    \n";
            }
            echo "</tr>\n";
        }
    }
}
unset($keys);
echo "\n</tbody></table>\n<p class=\"fixedbtn\">&nbsp;</p>\n</form></div></div> ";
$fileverioncheck = "6.1.0";

?>