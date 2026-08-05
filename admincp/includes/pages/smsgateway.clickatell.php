<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n";
licince\reqaddon("SMS");
$pageid = 478;
checkPagePermission($pageid);
$sql = mysqli_fetch_assoc(dquery("select * from tbl_settings where attribute='smsgateway'"));
$smsgatewayconfig = unserialize($sql["value"]);
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\" width=\"25%\">Clickatell ";
echo $LNG["api"];
echo " ";
echo $LNG["id"];
echo "</td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"clickatellapikey\"  value=\"";
echo $smsgatewayconfig["clickatellapikey"];
echo "\" /> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Clickatell ";
echo $LNG["username"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"clickatellusername\"  value=\"";
echo $smsgatewayconfig["clickatellusername"];
echo "\" /> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Clickatell ";
echo $LNG["password"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"clickatellpassword\"  value=\"";
echo $smsgatewayconfig["clickatellpassword"];
echo "\" /> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["senderid"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"senderid\"  value=\"";
echo $smsgatewayconfig["senderid"];
echo "\" /> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["force"];
echo " ";
echo $LNG["senderid"];
echo " </td>\n    <td class=\"fieldarea\">\n   <input type=\"radio\" name=\"forcesenderid\" value=\"1\" id=\"ac1\" ";
if ($smsgatewayconfig["forcesenderid"]) {
    echo "checked";
}
echo " /><label for=\"ac1\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"forcesenderid\" value=\"0\" id=\"ac2\" ";
if (!$smsgatewayconfig["forcesenderid"]) {
    echo "checked";
}
echo " /><label for=\"ac2\">";
echo $LNG["disable"];
echo "</label> \n     <small>";
echo $LNG["sederidnotice"];
echo "</small> \n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["smsunicode"];
echo " </td>\n    <td class=\"fieldarea\">\n  <input type=\"radio\" name=\"unicode\" value=\"1\" id=\"ac3\" ";
if ($smsgatewayconfig["unicode"]) {
    echo "checked";
}
echo " /><label for=\"ac3\">";
echo $LNG["enable"];
echo "</label>\n    <input type=\"radio\" name=\"unicode\" value=\"0\" id=\"ac4\" ";
if (!$smsgatewayconfig["unicode"]) {
    echo "checked";
}
echo " /><label for=\"ac4\">";
echo $LNG["disable"];
echo "</label> \n    <small>";
echo $LNG["smsunicodenote"];
echo "</small>\n    </td>\n</tr>\n</tbody>\n</table>\n\n<p align=\"center\" class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','smsgateway','#frm','#notification','true','#main_loader');\"/> \n</p>\n</form>\n\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>