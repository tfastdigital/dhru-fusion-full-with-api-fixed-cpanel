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
echo "<ul id=\"tabmenu\">\n <li><a ";
if (!$laoddefaultpage == "whiteip.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab1','main2.php?page=blockedip','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["blockedip"];
echo "</a></li>\n <li><a ";
if ($laoddefaultpage == "whiteip.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab2','main2.php?page=whiteip','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["whitelisted"];
echo " ";
echo $LNG["ip"];
echo "</a></li>\n <li><a ";
if ($laoddefaultpage == "cloudflare.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab3','main2.php?page=cloudflare','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >Cloudflare</a></li>\n <li><a ";
if ($laoddefaultpage == "cloudflareapi.php") {
    echo "class='tabmenu_active'";
}
echo " onclick=\"getContect('#tab4','main2.php?page=cloudflareapi','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Cloudflare APi</a></li>\n    <div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
if ($laoddefaultpage) {
    include $laoddefaultpage;
} else {
    include "blockedip.php";
}
echo "</div>\n";
$fileverioncheck = "6.1.0";

?>