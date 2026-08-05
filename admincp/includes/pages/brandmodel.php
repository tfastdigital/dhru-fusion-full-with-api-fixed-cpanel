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
echo "<ul id=\"tabmenu\"> \n<li><a ";
if (!$laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab','main2.php?page=brandlist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["brandlist"];
echo "</a></li> \n<li><a ";
if ($laoddefaultpage) {
    echo "class='tabmenu_active'";
}
echo "  onclick=\"getContect('#tab12','main2.php?page=modellist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["modellist"];
echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "brandlist.php";
}
echo "  </div>\n\n";
$fileverioncheck = "6.1.0";

?>