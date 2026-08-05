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
echo "<ul id=\"tabmenu\"> \n    <li><a class='tabmenu_active'  onclick=\"getContect('#tab','main2.php?page=blogcategorylist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["view"];
echo " ";
echo $LNG["category"];
echo "</a></li> \n   \n    <li><a onclick=\"getContect('#tab3','main2.php?page=blogcategoryadd','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n    \n    <div style=\"clear: both;\"></div>\n</ul>  \n\n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "blogcategorylist.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>