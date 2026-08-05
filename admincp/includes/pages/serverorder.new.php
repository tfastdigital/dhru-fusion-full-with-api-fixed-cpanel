<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 153;
checkPagePermission($pageid);
require_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$sql = dquery("select\n       id,service_name,API,(select count(order_id)  from tbl_order_server where\nservice_id=id and user_can_c='0') as cnt from tbl_server_log having cnt>0 order by id asc");
echo "<div id=\"content\"> \n<div id=\"content_padded\">\n<h2>    \n    <span class=\"groupstabesheadertext\">Service wise accept</span>\n  </h2><br />\n  \n<div id=\"notification\"></div>\n<form id=\"newimeiorder\" name=\"\" method=\"post\">     \n        \n    <table id='main_tbl'><thead>\n              <tr>\n                <th>";
echo $LNG["service"];
echo "</th>\n                <th>";
echo $LNG["order"];
echo "</th>\n                <th>";
echo $LNG["apicon"];
echo "</th>\n                <th>";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n";
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<tr>\n<td>";
    echo $row["service_name"];
    echo "</td>\n<td>";
    echo $row["cnt"];
    echo "</td>\n<td>";
    if ($row["API"]) {
        $s = mysqli_fetch_assoc(dquery("select value from tbl_apiservers where gateway='" . $row["API"] . "' and setting='name'"));
        echo $s["value"];
    } else {
        echo "NA";
    }
    echo "</td>\n<td align=\"right\"> \n";
    if ($row["API"]) {
        echo "<a class=\"\" onclick=\"if(confirm('This service is now connected to API. Do you want to Continue')) { getContect('#tab','main2.php?page=viewserverorder.new','";
        echo $row["id"];
        echo "','','#tabcontent',true,'#main_loader'); }\"  >";
        echo $LNG["vieworder"];
        echo "</a> \n    ";
    } else {
        echo "<a class=\"\" onclick=\"getContect('#tab','main2.php?page=viewserverorder.new','";
        echo $row["id"];
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["vieworder"];
        echo "</a>   \n";
    }
    echo "</td> \n</tr>\n";
}
echo "    \n  </table><br/>\n</form></div></div> \n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"http://kb.dhru.com/Dhru_Fusion/Server_Order/How_to_quick_accept_server_order\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div>";
}
$fileverioncheck = "6.1.0";

?>