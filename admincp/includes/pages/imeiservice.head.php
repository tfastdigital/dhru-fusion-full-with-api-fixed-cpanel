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
if ($server) {
    $language = $LNG["server"];
} else {
    $language = $LNG["imei"];
}
echo "<ul id=\"tabmenu\">\n<li><a ";
if (($page == "imeiservice" || $page == "imeiservice.list") && !$defaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab','main2.php?page=imeiservice.list";
echo $server ? "&server=" . $server : "";
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["all"];
echo "</a></li>\n\n<li><a ";
if ($defaultpage == "imeiquick.clientgroup.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab244','dist/#/productgrouppricing/";
echo $server == 1 ? "server" : ($server == 2 ? "remote" : "imei");
echo "','";
echo $id;
echo "','',\n            '#tabcontent',true,'#main_loader','','','',true);\" id=\"tab244\" >";
echo $LNG["pricing"];
echo "</a></li>\n\n<li><a onclick=\"getContect('#tab1','main2.php?page=imeiservice.addnew";
echo $server ? "&server=" . $server : "";
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >+";
echo $LNG["addservice"];
echo "</a></li>\n<li><a ";
if ($defaultpage == "imeiservice.tviewgroup.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=imeiservice.tviewgroup";
echo $server ? "&server=" . $server : "";
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["group"];
echo "</a></li>\n<li><a onclick=\"getContect('#tab3','main2.php?page=addimeigroup";
echo $server ? "&server=" . $server : "";
echo "','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >+";
echo $LNG["add"];
echo " ";
echo $LNG["group"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>";
$fileverioncheck = "6.1.0";

?>