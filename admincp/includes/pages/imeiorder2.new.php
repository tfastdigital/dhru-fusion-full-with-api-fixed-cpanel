<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 289;
checkPagePermission($pageid);
require_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$sql = dquery("select id,group_name from tbl_imei_group order by `display_order` ASC");
while ($row = mysqli_fetch_assoc($sql)) {
    $s = dquery("select id,service_name,API,(select count(*) as cnt from tbl_order_imei\n     where service_id=id) as cc\n     from tbl_services_imei where group_id='" . $row["id"] . "' having cc>0");
    while ($r = mysqli_fetch_assoc($s)) {
        if (mysqli_num_rows(dquery("select count(*) as \n         cnt from tbl_order_imei where service_id='" . $r["id"] . "' and\n         user_can_c=0 having cnt>0"))) {
            $det[md5($r["id"])] = $r;
        }
    }
    $imeiServiceDetails[$row["group_name"]] = $det;
    unset($det);
}
echo "\n<div id=\"content\"> \n<div id=\"content_padded\">\n<div id=\"notification\"></div>\n<form id=\"newimeiorder\" name=\"\" method=\"post\">     \n";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    $show = false;
    if (0 < count($imeiServiceDetails[$group])) {
        echo "        \n    <table id='main_tbl'><thead>\n              <tr>\n                <td width='25%' colspan='2'>";
        echo $group;
        echo "</td>\n                <td width='25%' align='center'>";
        echo $LNG["order"];
        echo "</td>\n                <td width='25%' align='center'>";
        echo $LNG["apicon"];
        echo "</td>\n                <td width='25%' align='right'>";
        echo $LNG["action"];
        echo "</td>\n              </tr>\n            </thead>\n";
        foreach ($imeiServiceDetails[$group] as $keys) {
            $cnt = mysqli_fetch_assoc(dquery("select count(*) as cnt from tbl_order_imei \n       where service_id='" . $keys["id"] . "' and user_can_c='0'"));
            echo "<tr>\n<td></td>\n<td>";
            echo $keys["service_name"];
            echo "</td>\n<td align=\"center\">";
            echo $cnt["cnt"];
            echo "</td>\n<td align=\"center\">";
            if ($keys["API"] != "") {
                $api = mysqli_fetch_assoc(dquery("SELECT `value` FROM `tbl_apiservers` WHERE `gateway`='" . $keys["API"] . "' AND `setting`='name'"));
                echo $api["value"];
            } else {
                echo "No";
            }
            echo "</td> \n<td align=\"right\"> \n";
            if ($keys["API"] != "") {
                echo "<a onclick=\"if(confirm('This service is now connected to API. Do you want to Continue')) { getContect('#tab','main2.php?page=viewimeiorder.new','";
                echo $keys["id"];
                echo "','','#tabcontent',true,'#main_loader'); }\"  >";
                echo $LNG["vieworder"];
                echo "</a></td>    \n    ";
            } else {
                echo "<a onclick=\"getContect('#tab','main2.php?page=viewimeiorder.new','";
                echo $keys["id"];
                echo "','','#tabcontent',true,'#main_loader');\"  >";
                echo $LNG["vieworder"];
                echo "</a></td>    \n";
            }
            echo "</tr>\n";
        }
        echo "    \n  </table><br/>\n";
    }
}
unset($keys);
echo "</form></div></div> \n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"http://kb.dhru.com/Dhru_Fusion/IMEI_order/How_to_quick_accept_new_order_of_IMEI\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div>";
}
$fileverioncheck = "6.1.0";

?>