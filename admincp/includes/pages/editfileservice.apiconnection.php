<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 284;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID,key_selling FROM tbl_services_file WHERE id='" . $id . "' "));
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method=\"post\" name=\"frmapi\" id=\"frmapi\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n\n<div  class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">API Connection</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["connect"];
echo " ";
echo $LNG["api"];
echo "</td>\n    <td class=\"fieldarea\">";
echo apiServerDropdown($serviceDetails["API"], "API", "FILE");
echo "</td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo " ";
echo $LNG["services"];
echo "</td>\n    <td class=\"fieldarea\"><div id=\"apiservicedropdown\" style=\"display: none;\"></div><span id=\"onloadapiservicedropdown\">";
echo apiServicesDropdown($serviceDetails["API"], $serviceDetails["API_ID"], "API_ID", "FILE");
echo "</span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n</div></div>\n\n<p  class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnapiconnection\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnapiconnection','editfileservice.apiconnection','#frmapi','#notification','true','#main_loader');\"/></p>\n</form>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>