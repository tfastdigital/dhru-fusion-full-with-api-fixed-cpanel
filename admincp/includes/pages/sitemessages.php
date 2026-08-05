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
echo "<ul id=\"tabmenu\"> \n    \n    <li><a class='tabmenu_active' \n    onclick=\"getContect('#tab','main2.php?page=maintenance','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["maintenance"];
echo " ";
echo $LNG["mode"];
echo "</a></li>\n    <li><a \n    onclick=\"getContect('#tab2','main2.php?page=usermessage','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["user"];
echo " ";
echo $LNG["notification"];
echo "</a></li> \n   <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
include "maintenance.php";
echo "  </div>  \n";
$fileverioncheck = "6.1.0";

?>