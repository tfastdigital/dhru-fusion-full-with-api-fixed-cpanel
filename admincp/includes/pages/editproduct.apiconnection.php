<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 357;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_products WHERE id='" . $id . "' "));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["connect"];
echo " ";
echo $LNG["api"];
echo "</td>\n    <td class=\"fieldarea\">";
echo apiServerDropdown($serviceDetails["API"], "API");
echo "</td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["api"];
echo " ";
echo $LNG["services"];
echo "</td>\n    <td class=\"fieldarea\"><div id=\"apiservicedropdown\" style=\"display: none;\"></div><span id=\"onloadapiservicedropdown\">";
echo apiServicesDropdown($serviceDetails["API"], $serviceDetails["API_ID"], "API_ID");
echo "</span></td>\n</tr>\n\n\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnapiconnection\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnapiconnection','editproduct.apiconnection','#frmapi','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>