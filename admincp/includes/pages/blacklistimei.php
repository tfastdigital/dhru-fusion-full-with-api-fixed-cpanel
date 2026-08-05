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
echo "<ul id=\"tabmenu\">\r\n    <li><a ";
if ($laoddefaultpage == "blockimei.php" || !$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=blockimei','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["add"];
echo " IMEI</a></li>\r\n    <li><a ";
if ($laoddefaultpage == "blockimeilist.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=blockimeilist','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >Blacklist IMEI</a></li>\r\n    <div style=\"clear: both;\"></div>\r\n</ul>\r\n    <div id=\"tabcontent\">\r\n        ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "blockimei.php";
}
echo "    </div>\r\n";
$fileverioncheck = "6.1.0";

?>