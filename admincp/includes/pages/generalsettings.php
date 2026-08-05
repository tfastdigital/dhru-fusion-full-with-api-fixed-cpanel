<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 52;
checkPagePermission($pageid);
echo "\n\n<div class=\"sidemenu-bar\">\n\n<ul id=\"tabmenu\">\n\n    <li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=settinggeneral','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["general"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab2','main2.php?page=settingregistration','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["registration"];
echo " / " . $LNG["profile"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab30','main2.php?page=settingshop','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab30\" >";
echo $LNG["shopping"];
echo " ";
echo $LNG["cart"];
echo "</a></li>\n    ";
if (licince\reqaddon("Reward Points System", true)) {
    echo "    <li>\n        <a onclick=\"getContect('#tab36','main2.php?page=rewardpoints','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n           id=\"tab36\">";
    echo $LNG["reward"];
    echo " ";
    echo $LNG["points"];
    echo "</a></li>\n    ";
}
echo "    <li><a onclick=\"getContect('#tab3','main2.php?page=settinglocalisation','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["localisation"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab5','main2.php?page=settinginvoice','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["tax"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab35','main2.php?page=settinginvoices','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab35\" >";
echo $LNG["invoice"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab55','main2.php?page=contactussetting','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab55\" >";
echo $LNG["contactus"];
echo "</a></li>\n\n";
if (!$OnlyEcommerce) {
    echo "    <li><a onclick=\"getContect('#tab7','main2.php?page=settingorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab7\" >";
    echo $LNG["orders"];
    echo "</a></li>\n    <!--\n<li><a onclick=\"getContect('#tab9','main2.php?page=recentmenu','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab9\" >";
    echo $LNG["quick"];
    echo " ";
    echo $LNG["access"];
    echo " ";
    echo $LNG["menu"];
    echo "</a></li>\n-->\n";
}
echo "    <li><a onclick=\"getContect('#tab93','main2.php?page=fraudprotection','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab93\" >";
echo $LNG["fraudprotection"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab8','main2.php?page=settingappear','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab8\" >";
echo $LNG["appearance"];
echo "</a></li>\n<!--\n    <li><a onclick=\"getContect('#tab31','main2.php?page=settingapp','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab31\" >Mobile App</a></li>\n-->\n    ";
if (licince\reqaddon("Wallet merchant", true)) {
    echo "    <li><a onclick=\"getContect('#tab31','main2.php?page=settingwallet','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab31\" >";
    echo $LNG["walletmerchant"];
    echo "</a></li>\n    ";
}
echo "    <li><a onclick=\"getContect('#tab11','main2.php?page=settingother','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
echo $LNG["other"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n\n    ";
if (!$mobilebrowser) {
    echo "        <link   href=\"templates/";
    echo $_SESSION["admin_template"];
    echo "/x-main2-new.css?v=";
    echo $versioncatch;
    echo "\" rel=\"stylesheet\">\n        ";
}
echo "\n</ul>\n\n</div>\n<div id=\"tabcontent\"> ";
include "settinggeneral.php";
echo "  </div>  ";
$fileverioncheck = "6.1.0";

?>