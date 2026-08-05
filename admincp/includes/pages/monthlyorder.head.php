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
if (!$IsFileOnly) {
    echo "<ul id=\"tabmenu\"> \n ";
    if (!$OnlyEcommerce) {
        echo "<li><a ";
        if ($page == "monthlyorder" || $page == "imeiorder.report") {
            echo "class='tabmenu_active'";
        }
        echo "  onclick=\"getContect('#tab','main2.php?page=imeiorder.report&laoddefaultpage=imeiorder.report.php','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imeiorder"];
        echo "</a></li> \n<li><a ";
        if ($page == "fileorder.report") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab3','main2.php?page=fileorder.report&laoddefaultpage=fileorder.report.php','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["fileorder"];
        echo "</a></li>\n<li><a ";
        if ($page == "imeiorder.report") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab6','main2.php?page=imeiorder.report&newserver=1&laoddefaultpage=imeiorder.report.php','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
        echo $LNG["serverorder"];
        echo " ";
        echo $LNG["with"];
        echo " ";
        echo $LNG["api"];
        echo "</a></li>\n<li><a ";
        if ($page == "serverorder.report") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab4','main2.php?page=serverorder.report&laoddefaultpage=serverorder.report.php','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
        echo $LNG["serverorder"];
        echo "</a></li>\n ";
    }
    echo "<li><a ";
    if ($page == "productorder.report") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab5','main2.php?page=productorder.report&laoddefaultpage=productorder.report.php','','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >";
    echo $LNG["productorder"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n";
}
$fileverioncheck = "6.1.0";

?>