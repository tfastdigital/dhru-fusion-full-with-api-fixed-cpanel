<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n";
$pageid = 67;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
echo "<script>\n    function newWindow(file,window)\n    {   msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n        if (msgWindow.opener == null) msgWindow.opener = self;\n    }\n</script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["category"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"category\"  value=\"\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" width=\"150px\">";
echo $LNG["description"];
echo " </td>\n    <td class=\"fieldarea\"><textarea name=\"info\" rows=\"15\" style=\" width:100%;\"></textarea></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["iconlink"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"image\" id=\"iconlink\" value=\"";
echo $imeiserviceDetails["icon_link"];
echo "\" type=\"text\"  class=\"txt\"/> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\"/></td>\n</tr>\n<tr>\n    <td></td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','knowledgebasecatadd','#frm','#notification','true','#main_loader');\"/> </td>\n</tr>\n</tbody>\n</table>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>