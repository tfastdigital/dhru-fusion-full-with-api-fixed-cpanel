<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 515;
checkPagePermission($pageid);
echo "<ul id=\"tabmenu\"> \n<li><a ";
if (!$laoddefaultpage == "api.cleanup.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=api.service','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["services"];
echo "</a></li>\n<li><a  onclick=\"getContect('#tab2','main2.php?page=api.cleanup','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["api"];
echo " ";
echo $LNG["cleanup"];
echo "</a></li>   \n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "api.service.php";
}
echo "\n</div>\n";
$fileverioncheck = "6.1.0";

?>