<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "supplier.head.php";
echo "<style>\n.form{margin-bottom: 4px !important;}\n</style>\n";
licince\chkLitePlus();
licince\chklite();
$pageid = 112;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" class=\"groupstabescontant\">\n<form id=\"frmaddsup\" name=\"\" method=\"post\">\n\n\n";
echo generate_token("form");
echo "\n<table class=\"form\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["username"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"username\"  type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["password"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"password\"  value=\"\" type=\"password\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"email\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["phone"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"phone\" style=\"width: 150px;\" value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n    <span><input type=\"radio\" id=\"active\" name=\"status\" value=\"1\" checked=\"checked\"/><label for=\"active\">";
echo $LNG["active"];
echo "</label></span>\n    <span><input type=\"radio\" name=\"status\" id=\"blocked\" value=\"0\" /><label for=\"blocked\">";
echo $LNG["blocked"];
echo "</label></span>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["servicesaccess"];
echo "</td>\n    <td class=\"fieldarea\">\n";
$services = explode(",", $config["default_service"]);
echo "\n  ";
if ($SUPPLIERSP && !$IsFileOnly) {
    echo " <span><input type=\"checkbox\" name=\"shopaccess\" id=\"shop\" checked=\"checked\" value=\"1\" ";
    if ($config["default_service_shop"]) {
        echo "checked";
    }
    echo "/><label for=\"shop\">";
    echo $LNG["shop"];
    echo "</label></span>\n";
}
echo "    \n</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["address"];
echo "</td>\n    <td class=\"fieldarea\"><textarea name=\"address\"></textarea></td>\n</tr>\n<tr> \n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "</td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown();
echo "</td>\n</tr>\n<tr>\n<td class=\"fieldlabel\"></td>\n<td><input type=\"checkbox\" id=\"sendmail\" name=\"sendmail\" checked=\"checked\"/><label for=\"sendmail\">";
echo $LNG["sendmail"];
echo "</label></td>\n</tr>\n<tr>\n<td class=\"fieldlabel\"></td>\n<td>\n<input value=\"";
echo $LNG["add"];
echo "\" \nid=\"btnaddclient\" class=\"btn\" type=\"button\" \n onclick=\"SubmitForm ('#btnaddclient','addnewsupplier','#frmaddsup','#notification','true','#main_loader');\"/>\n</td>\n</tr>\n</tbody>\n</table>\n\n\n</form>\n</div>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>