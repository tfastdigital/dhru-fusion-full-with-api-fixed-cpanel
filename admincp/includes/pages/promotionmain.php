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
echo "<ul id=\"tabmenu\"> \n     <li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=promotion','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["promotion"];
echo " ";
echo $LNG["code"];
echo "</a></li>\n     <li><a ";
if ($laoddefaultpage == "usedpromotion.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=usedpromotion','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["used"];
echo " ";
echo $LNG["codelist"];
echo "</a></li>\n     <li><a ";
if ($laoddefaultpage == "pendingpromotion.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab33','main2.php?page=pendingpromotion','','','#tabcontent',true,'#main_loader');\" id=\"tab33\" >";
echo $LNG["pending"];
echo " ";
echo $LNG["codelist"];
echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n    ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "promotion.php";
}
echo "</div>";
$fileverioncheck = "6.1.0";

?>