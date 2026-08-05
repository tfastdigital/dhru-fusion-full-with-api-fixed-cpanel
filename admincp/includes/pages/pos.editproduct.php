<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 346;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
$happyhours = getProducthappyhours($id);
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", $productDetails["group_id"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n\n<div  class=\"groupstabes\" >\n  \n  <div class=\"groupstabescontant\">\n  \n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n \n \n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["servicename"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"servicename\"  value=\"";
echo $productDetails["service_name"];
echo "\" type=\"text\"  class=\"txt large\"/> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["service"];
echo " ";
echo $LNG["listedin"];
echo " ";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\">\n        ";
echo $grp;
echo " \n  \n</td>\n</tr>\n \n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["price"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"credit\"  value=\"";
echo $productDetails["credit_admin"];
echo "\"\n     type=\"text\"  class=\"txt small\" onkeyup=\"return cF(this,false)\" onblur=\"return cF(this,true)\"/>\n    <span class=\"preforms\">";
echo $config["base_currency"];
echo "</span>  \n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editproduct.overview','#frm','#notification','true','#main_loader');\"/> \n    </td>\n</tr>\n \n\n</tbody>\n</table>\n\n \n\n</div></div>\n \n\n</form>\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>