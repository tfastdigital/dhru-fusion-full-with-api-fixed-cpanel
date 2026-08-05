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
echo "<ul id=\"tabmenu\">\n\n    <li><a ";
if (!$laoddefaultpage || $laoddefaultpage == "softwarekey.list.php") {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab2','main2.php?page=softwarekey.list','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["instock"];
echo "</a></li>\n    <li><a ";
if ($laoddefaultpage == "soldstock.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab5','main2.php?page=soldstock','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
echo $LNG["soldstock"];
echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=softwarekey','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" > + ";
echo $LNG["add"];
echo " ";
echo $LNG["stock"];
echo "</a></li>\n    <li><a  ";
if ($laoddefaultpage == "softwarekeygroup.php") {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab3','main2.php?page=softwarekeygroup','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" > ";
echo $LNG["inventory"];
echo " ";
echo $LNG["groups"];
echo "</a></li>\n\n    <div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "softwarekey.list.php";
}
echo "\n</div>";
$fileverioncheck = "6.1.0";

?>