<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
$pageid = 79;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"200px\">";
echo $LNG["category"];
echo " ";
echo $LNG["name"];
echo "*</td>\n    <td class=\"fieldarea\"><input name=\"category\"  value=\"\" type=\"text\"/></td>\n</tr>\n\n\n</tbody>\n</table>\n\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','blogcategory','#frm','#notification','true','#main_loader');\"/> </p>\n\n</form>\n</div></div>";
$fileverioncheck = "6.1.0";

?>