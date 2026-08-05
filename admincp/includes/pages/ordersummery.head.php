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
        if ($page == "ordersummery" || $page == "imeiorder.summery") {
            echo "class='tabmenu_active'";
        }
        echo "   onclick=\"getContect('#tab','main2.php?page=imeiorder.summery','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imeiorder"];
        echo "</a></li>\n";
    }
    echo " \n<li><a ";
    if ($page == "fileorder.summery") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab12','main2.php?page=fileorder.summery','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["fileorder"];
    echo "</a></li>\n";
    if (!$IsFileOnly) {
        echo "<li><a ";
        if ($page == "serverorder.summery") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab3','main2.php?page=serverorder.summery','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["serverorder"];
        echo "</a></li>\n<li><a ";
        if ($page == "remoteorder.summery") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab6','main2.php?page=remoteorder.summery','','','#tabcontent',true,'#main_loader');\" id=\"tab6\" >";
        echo $LNG["remote"];
        echo " ";
        echo $LNG["order"];
        echo "</a></li>\n";
    }
}
if (!$IsFileOnly) {
    echo "<li><a ";
    if ($page == "productorder.summery") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab4','main2.php?page=productorder.summery','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["productorder"];
    echo "</a></li>\n";
}
echo "<div style=\"clear: both;\"></div>\n</ul> \n";
$fileverioncheck = "6.1.0";

?>