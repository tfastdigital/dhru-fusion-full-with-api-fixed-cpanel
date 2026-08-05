<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 483;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n    ";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "    <li><a ";
        if ($defaultloadpage != "stockproduct.php") {
            echo "class='tabmenu_active'";
        }
        echo "   onclick=\"getContect('#tab','main2.php?page=stockimei','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imei"];
        echo "</a></li>\n    ";
    }
    echo " \n    <li><a onclick=\"getContect('#tab1','main2.php?page=stockfile','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["file"];
    echo "</a></li>\n    ";
    if (!$IsFileOnly) {
        echo " \n    <li><a onclick=\"getContect('#tab3','main2.php?page=stockserver','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo "</a></li>\n    ";
    }
}
if (!$IsFileOnly) {
    echo "    \n    <li><a ";
    if ($defaultloadpage == "stockproduct.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab11','main2.php?page=stockproduct','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["product"];
    echo "</a></li>\n    ";
}
echo "    \n<div style=\"clear: both;\"></div>\n</ul>\n \n\n";
if (!$OnlyEcommerce && !$IsFileOnly) {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "stockimei.php";
    }
    echo "</div>\n";
} else {
    if ($IsFileOnly) {
        echo "<div id=\"tabcontent\"> ";
        include "stockfile.php";
        echo "</div>\n";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "stockproduct.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>