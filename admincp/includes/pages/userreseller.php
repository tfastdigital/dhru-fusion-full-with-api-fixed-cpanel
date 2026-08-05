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
echo "<ul id=\"tabmenu\"> \n\n     <li><a onclick=\"getContect('#tab1','main2.php?page=activitylog','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["activity"];
echo " ";
echo $LNG["log"];
echo "</a></li>\n     <li><a onclick=\"getContect('#tab2','main2.php?page=viewpage','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["viewpages"];
echo "</a></li>\n \n<div style=\"clear: both;\"></div> \n</ul>  \n<div id=\"tabcontent\"> ";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "activitylog.php";
}
echo "  </div>\n";
$fileverioncheck = "6.1.0";

?>