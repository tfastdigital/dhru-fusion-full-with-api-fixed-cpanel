<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 6;
checkPagePermission($pageid);
if ($IsFileOnly) {
    echo "  <div id=\"tabcontent\"> ";
    include "salesbyfile.php";
    echo "</div>\n  ";
} else {
    echo "\n<ul id=\"tabmenu\"> \n    ";
    if (!$OnlyEcommerce) {
        echo "        <li><a ";
        if (!$defaultloadpage || $defaultloadpage == "salesbyimei.php" && !$newserver) {
            echo " class='tabmenu_active' ";
        }
        echo " onclick=\"getContect('#tab','main2.php?page=salesbyimei','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imei"];
        echo "</a></li>\n        <li><a ";
        if ($defaultloadpage == "salesbyfile.php") {
            echo " class='tabmenu_active' ";
        }
        echo " onclick=\"getContect('#tab1','main2.php?page=salesbyfile','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
        echo $LNG["file"];
        echo "</a></li>\n        <li><a ";
        if ($newserver == 1) {
            echo " class='tabmenu_active' ";
        }
        echo " onclick=\"getContect('#tab4','main2.php?page=salesbyimei&newserver=1','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["with"];
        echo " ";
        echo $LNG["api"];
        echo "</a></li>\n        <li><a ";
        if ($newserver == 2) {
            echo " class='tabmenu_active' ";
        }
        echo " onclick=\"getContect('#tab5','main2.php?page=salesbyimei&newserver=2','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
        echo $LNG["remote"];
        echo "</a></li>\n        <li><a onclick=\"getContect('#tab3','main2.php?page=salesbyserver','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo "</a></li>\n    ";
    }
    echo "    \n    <li><a onclick=\"getContect('#tab11','main2.php?page=salesbyshop','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["product"];
    echo "</a></li>    \n<div style=\"clear: both;\"></div>\n</ul>\n \n";
    if (!$OnlyEcommerce) {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "salesbyimei.php";
        }
        echo "</div>\n";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "salesbyshop.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>