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
echo "<ul id=\"tabmenu\">\n\n<li><a class='tabmenu_active' onclick=\"getContect('#tab1','main2.php?page=utilities.seo.xml','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["generate"];
echo " XML ";
echo $LNG["sitemap"];
echo "</a></li>\n<!--<li><a onclick=\"getContect('#tab2','main2.php?page=utilities.seo.google','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >Google base </a></li>\n-->   \n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "utilities.seo.xml.php";
}
echo "\n</div>";
$fileverioncheck = "6.1.0";

?>