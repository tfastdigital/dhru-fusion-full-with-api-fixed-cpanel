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
echo "<ul id=\"tabmenu\"> \n<li class=\"tabmenu-header\"><span>Submenu</span></li>\n<span class=\"toggle-tabmenu\"><span>::</span><span style=\"margin-top:-5px;\">::</span></span>\n <li><a   class='tabmenu_active'   onclick=\"getContect('#tab3','main2.php?page=cloudbanner','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >Banners</a></li>\n <li><a  ";
if ($laoddefaultpage == "cloudtheme.php") {
    echo "class='tabmenu_active'";
}
echo "   onclick=\"getContect('#tab4','main2.php?page=cloudtheme','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Templates</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\"> \n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
    $laoddefaultpage = NULL;
} else {
    include "cloudbanner.php";
}
echo "</div>\n\n\n\n\n";
$fileverioncheck = "6.1.0";

?>