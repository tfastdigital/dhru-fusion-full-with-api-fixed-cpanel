<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 486;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n    <li><a ";
if (!$loaddefault) {
    echo " class='tabmenu_active' ";
}
echo " \n   \n    onclick=\"getContect('#tab','main2.php?page=pos.products','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\">";
echo $LNG["products"];
echo "</a></li> \n    <li><a ";
if ($loaddefault) {
    echo " class='tabmenu_active' ";
}
echo " \n    onclick=\"getContect('#tab1','main2.php?page=pos.barcode','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\">";
echo $LNG["generate"];
echo " ";
echo $LNG["barcode"];
echo "</a></li>\n   <li><a \n    onclick=\"getContect('#tab2','main2.php?page=pos.setting','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\">";
echo $LNG["settings"];
echo "</a></li> \n   \n    <li><a \n    onclick=\"getContect('#tab3','main2.php?page=pos.addproduct','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\">";
echo $LNG["add"];
echo " ";
echo $LNG["product"];
echo "</a></li> \n   \n    \n   <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
if ($loaddefault) {
    include $loaddefault;
} else {
    include "pos.products.php";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>