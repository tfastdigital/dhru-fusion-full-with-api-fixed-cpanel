<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n";
$pageid = 452;
checkPagePermission($pageid);
echo " \n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\"> \n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" value=\"\" name=\"tinyvalue\" id=\"tinyvalue\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["siteundermaintanance"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"radio\" name=\"config_is_under_maintanance\" id=\"em\" value=\"1\" ";
if ($config_is_under_maintanance["value"]) {
    echo "checked";
}
echo " /><label for=\"em\" >";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"config_is_under_maintanance\" id=\"dm\" value=\"0\" ";
if (!$config_is_under_maintanance["value"]) {
    echo "checked";
}
echo " /><label for=\"dm\" >";
echo $LNG["disable"];
echo "</label>\n    </td>\n</tr>\n<tr> \n    <td class=\"fieldlabel\">&nbsp;</td><td>\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\" name=\"save\"  onclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('maintanance_message').getContent(); SubmitForm ('#btnaddgroup','maintenance','#frm','#notification','true','#main_loader');\"/> \n    </td>\n</tr>\n\n</tbody>\n</table>\n\n\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>