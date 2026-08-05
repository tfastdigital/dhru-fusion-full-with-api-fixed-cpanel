<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 518;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "<li><a class='tabmenu_active' onclick=\"getContect('#tab','main2.php?page=supplierimeiorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >IMEI ";
        echo $LNG["order"];
        echo "</a></li>\n    ";
    }
    echo "<li><a onclick=\"getContect('#tab1','main2.php?page=supplierfileorder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["file"];
    echo "  ";
    echo $LNG["order"];
    echo "</a></li>\n";
    if (!$IsFileOnly) {
        echo " \n<li><a onclick=\"getContect('#tab5','main2.php?page=supplierimeiorder&newserver=1','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["with"];
        echo " ";
        echo $LNG["api"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li>\n\n<li><a onclick=\"getContect('#tab3','main2.php?page=supplierserverorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li>\n<li><a onclick=\"getContect('#tab4','main2.php?page=supplierremoteorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
        echo $LNG["remote"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li>\n";
    }
}
echo "    \n";
if ($SUPPLIERSP && !$IsFileOnly) {
    echo "<li><a onclick=\"getContect('#tab11','main2.php?page=suppliershoporder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["product"];
    echo "  ";
    echo $LNG["order"];
    echo "</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n</ul>\n<br />\n";
if (!$OnlyEcommerce && !$IsFileOnly) {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "supplierimeiorder.php";
    }
    echo "</div>\n";
} else {
    if ($IsFileOnly) {
        echo "<div id=\"tabcontent\"> ";
        include "supplierfileorder.php";
        echo "</div>\n";
    } else {
        echo "<div id=\"tabcontent\"> ";
        if ($defaultloadpage) {
            include $defaultloadpage;
        } else {
            include "suppliershoporder.php";
        }
        echo "</div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>