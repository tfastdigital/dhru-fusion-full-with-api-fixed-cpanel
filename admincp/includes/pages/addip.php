<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 151;
checkPagePermission($pageid);
echo "  \n\n<style>\n\n.form{margin-bottom: 4px !important;}\n\n</style>\n\n\n\n<div id=\"notification\"></div>\n\n<div id=\"content\" style=\"width: 100%;!important \">\n\n<div id=\"content_padded\" style=\"width: 100%;!important \">\n\n\n<form method=\"post\" id=\"frms\">\n<table id=\"main_tbl\" >\n<tbody> \n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["add"];
echo " ";
echo $LNG["ip"];
echo " *</td>\n<td class=\"fieldarea\"><textarea name=\"ips\" rows=\"5\"></textarea></td>\n</tr>\n\n\n</tbody></table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','blockedip','#frms','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n\n\n\n\n</div>\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>