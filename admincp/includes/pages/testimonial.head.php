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
if (!$laoddefaultpage && !$delete) {
    echo " class=\"tabmenu_active\" ";
}
echo " onclick=\"getContect('#tab1','main2.php?page=listtestimonial','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["list"];
echo " ";
echo $LNG["testimonial"];
echo "</a></li>\n     <li><a ";
if ($laoddefaultpage == "addtestimonial.php") {
    echo " class=\"tabmenu_active\" ";
}
echo " href=\"main2.php?page=testimonial&laoddefaultpage=addtestimonial.php\" id=\"tab2\" >";
echo $LNG["add"];
echo " ";
echo $LNG["testimonial"];
echo "</a></li> \n    <div style=\"clear: both;\"></div>\n</ul>  ";
$fileverioncheck = "6.1.0";

?>