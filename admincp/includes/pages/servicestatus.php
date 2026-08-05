<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 513;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n";
if (!$OnlyEcommerce) {
    echo "<li><a ";
    if ($laoddefaultpage == "imeistatus.php" || !$laoddefaultpage) {
        echo "class='tabmenu_active'";
    }
    echo "   onclick=\"getContect('#tab','main2.php?page=imeistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["status"];
    echo "</a></li> \n<li><a ";
    if ($laoddefaultpage == "serverstatus.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=serverstatus&laoddefaultpage=serverstatus.php','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["server"];
    echo " ";
    echo $LNG["with"];
    echo " ";
    echo $LNG["api"];
    echo " ";
    echo $LNG["status"];
    echo "</a></li>\n<li><a ";
    if ($laoddefaultpage == "remotestatus.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab5','main2.php?page=remotestatus&laoddefaultpage=remotestatus.php','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
    echo $LNG["remote"];
    echo " ";
    echo $LNG["status"];
    echo "</a></li>\n";
}
echo "<li><a ";
if ($laoddefaultpage == "productstatus.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab4','main2.php?page=productstatus&laoddefaultpage=productstatus.php','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
echo $LNG["product"];
echo " ";
echo $LNG["status"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n\n";
if (!$OnlyEcommerce) {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "imeistatus.php";
    }
    echo "</div>\n";
} else {
    echo "<div id=\"tabcontent\"> ";
    if ($defaultloadpage) {
        include $defaultloadpage;
    } else {
        include "productstatus.php";
    }
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>