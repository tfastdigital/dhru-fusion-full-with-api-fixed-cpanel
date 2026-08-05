<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 514;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "<li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=refundimei','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >IMEI ";
        echo $LNG["order"];
        echo "</a></li>\n";
    }
    echo " \n<li><a onclick=\"getContect('#tab1','main2.php?page=refundfile','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["file"];
    echo "  ";
    echo $LNG["order"];
    echo "</a></li>\n";
    if (!$IsFileOnly) {
        echo "<li><a onclick=\"getContect('#tab5','main2.php?page=refundimei&newserver=1','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["with"];
        echo " ";
        echo $LNG["api"];
        echo " ";
        echo $LNG["order"];
        echo "</a></li>\n \n<li><a onclick=\"getContect('#tab3','main2.php?page=refundserver','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li>\n";
    }
}
if (!$IsFileOnly) {
    echo "    \n<li><a onclick=\"getContect('#tab11','main2.php?page=refundshop','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["product"];
    echo "  ";
    echo $LNG["order"];
    echo "</a></li>\n";
}
echo "    \n<div style=\"clear: both;\"></div>\n</ul>\n<br />\n";
if (!$OnlyEcommerce && !$IsFileOnly) {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "refundimei.php";
    }
    echo "</div>\n";
} else {
    if ($IsFileOnly) {
        echo "<div id=\"tabcontent\"> ";
        include "refundfile.php";
        echo "</div>\n";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "refundshop.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>