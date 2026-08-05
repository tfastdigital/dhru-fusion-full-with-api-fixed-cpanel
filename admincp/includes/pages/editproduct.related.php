<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include_once ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$md5id = md5($id);
$productDetails = getProducts("", $md5id);
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "groupname", "");
echo "<div id=\"notification\"></div>\n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"frm\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["group"];
echo "</td>\n<td class=\"fieldarea\" >\n<span>\n    ";
echo $grp;
echo " <input type=\"button\" name=\"show\" class=\"addFromgallery\" onclick=\"javascript:getContect('#products','main2.php?page=relatedproduct',document.frm.groupname.value,'";
echo $id;
echo "','#loadpro',true,'#main_loader');\" id=\"products\"  value=\"";
echo $LNG["show"] . " " . $LNG["products"];
echo "\"/>\n</span> </td>\n</tr>\n \n\n</tbody>\n</table>\n\n<div id=\"loadpro\"></div>\n\n<div class=\"fixedbtn\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','relatedproduct','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n</div>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>