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
echo "<ul id=\"tabmenu\"> \n";
if (!$OnlyEcommerce) {
    if (!$IsFileOnly) {
        echo "<li><a ";
        if (($laoddefaultpage == "imeiprofit.php" || !$laoddefaultpage) && $server != 2) {
            echo "class='tabmenu_active'";
        }
        echo "   onclick=\"getContect('#tab','main2.php?page=imeiprofit','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imei"];
        echo " ";
        echo $LNG["profit"];
        echo "</a></li>\n";
    }
    echo " \n<li><a ";
    if ($laoddefaultpage == "fileprofit.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab12','main2.php?page=fileprofit&laoddefaultpage=fileprofit.php','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["file"];
    echo " ";
    echo $LNG["profit"];
    echo "</a></li>\n";
    if (!$IsFileOnly) {
        echo "<li><a ";
        if ($laoddefaultpage == "serverprofit.php") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab3','main2.php?page=serverprofit&laoddefaultpage=serverprofit.php','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["profit"];
        echo "</a></li>\n\n<li><a ";
        if ($laoddefaultpage == "imeiprofit.php" && $server == 2) {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab4','main2.php?page=imeiprofit&server=2&laoddefaultpage=imeiprofit.php','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
        echo $LNG["remote"];
        echo " ";
        echo $LNG["profit"];
        echo "</a></li>\n\n        ";
    }
}
if (!$IsFileOnly) {
    echo "<li><a ";
    if ($laoddefaultpage == "productprofit.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab43','main2.php?page=productprofit&laoddefaultpage=productprofit.php','','','#tabcontent',true,'#main_loader');\" id=\"tab43\" >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["profit"];
    echo "</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n</ul>";
$fileverioncheck = "6.1.0";

?>