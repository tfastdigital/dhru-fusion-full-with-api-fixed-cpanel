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
licince\chklite();
echo "    <ul id=\"tabmenu\">\n\n        <li><a class=\"tabmenu_active\"  onclick=\"getContect('#tab7','main2.php?page=merchanttransactionlist&view=all','','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >";
echo $LNG["all"];
echo "</a></li>\n        <li><a   onclick=\"getContect('#tab2','main2.php?page=merchanttransactionlist&view=unpaid','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["unpaid"];
echo " / ";
echo $LNG["incomplete"];
echo "</a></li>\n        <li><a  onclick=\"getContect('#tab5','main2.php?page=merchanttransactionlist&view=paid','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["paid"];
echo "</a></li>\n\n        <div style=\"clear: both;\"></div>\n    </ul>\n    <div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "merchanttransactionlist.php";
}
echo "\n    </div>";
$fileverioncheck = "6.1.0";

?>