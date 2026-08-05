<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 497;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n<li><a  ";
if (!$defaultloadpage || $defaultloadpage == "language.add.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab12','main2.php?page=language.add','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["user"];
echo " ";
echo $LNG["language"];
echo "</a></li>\n<li><a  ";
if ($defaultloadpage == "language.edit.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab','main2.php?page=language.edit','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["admin"];
echo " ";
echo $LNG["language"];
echo "</a></li> \n\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($defaultloadpage) {
    include $defaultloadpage;
} else {
    include "language.add.php";
}
echo "    </div>";
$fileverioncheck = "6.1.0";

?>