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
echo "<ul id=\"tabmenu\"> \n    <li><a  ";
if (!$defaultpage == "addcurrency.php") {
    echo "class='tabmenu_active'";
}
echo "onclick=\"getContect('#tab','main2.php?page=currencies.list','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["currencies"];
echo "</a></li> \n    <!--\n<li><a ";
if ($defaultpage == "addcurrency.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=addcurrency','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["addcurrenc"];
echo " </a></li>\n-->      \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($defaultpage) {
    include $defaultpage;
} else {
    include "currencies.list.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>