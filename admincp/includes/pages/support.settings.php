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
licince\chkLitePlus();
licince\chklite();
echo "<ul id=\"tabmenu\">\n\n    <li><a ";
if (!$defaultloadpage) {
    echo " class='tabmenu_active' ";
}
echo "                onclick=\"getContect('#tab33','main2.php?page=supportsettings','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n                id=\"tab33\">";
echo $LNG["support"];
echo " ";
echo $LNG["settings"];
echo "</a></li>\n\n\n\n    <li><a\n\t\tonclick=\"getContect('#tab','main2.php?page=support.department','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab\">";
echo $LNG["support"];
echo " / ";
echo $LNG["livehelp"];
echo " ";
echo $LNG["department"];
echo "</a></li>\n\t<li><a ";
if ($defaultloadpage == "support.status.php") {
    echo "\t\tclass='tabmenu_active' ";
}
echo "\t\tonclick=\"getContect('#tab1','main2.php?page=support.status','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab1\">";
echo $LNG["ticket"] . " " . $LNG["status"];
echo "</a></li>\n\t<li><a ";
if ($defaultloadpage == "support.priority.php") {
    echo "\t\tclass='tabmenu_active' ";
}
echo "\t\tonclick=\"getContect('#tab2','main2.php?page=support.priority','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab2\">";
echo $LNG["ticket"] . " " . $LNG["priority"];
echo "</a></li>\n\t<li><a ";
if ($page == "support.tag") {
    echo "class='tabmenu_active'";
}
echo "\t\tonclick=\"getContect('#tab3','main2.php?page=support.tag','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab3\">";
echo $LNG["taggenerator"];
echo "</a></li>\n\n\t<div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "supportsettings.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>