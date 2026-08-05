<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n }\n</script>\n";
licince\chkLitePlus();
licince\chklite();
licince\reqaddon("E-commerce");
$pageid = 305;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/fileservices.fun.php";
$md5id = md5($id);
$fileserviceDetails = getFileServices("", $md5id);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n     <td class=\"fieldlabel\" width=\"15%\">";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo "</td>\n   <td class=\"fieldarea\"><input ";
if ($fileserviceDetails["retail"] == "1") {
    echo "checked=checked";
}
echo " name=\"retail\" value=\"1\" type=\"radio\" id=\"mep1\"/><label for=\"mep1\">";
echo $LNG["yes"];
echo "</label> <input ";
if ($fileserviceDetails["retail"] == "0") {
    echo "checked=checked";
}
echo " name=\"retail\" value=\"0\" type=\"radio\" id=\"mep0\"/><label for=\"mep0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\" value=\"";
echo $fileserviceDetails["image_link"];
echo "\" name=\"imagelink\" id=\"imagelink\"/> <input value=\"Add\" type=\"button\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname1')\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["hotdeals"];
echo "</td>\n   <td class=\"fieldarea\"><input type=\"text\" value=\"";
echo $fileserviceDetails["image_hotdeal"];
echo "\" name=\"image_hotdeal\" id=\"image_hotdeal\" /> <input value=\"";
echo $LNG["add"];
echo "\" type=\"button\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=image_hotdeal', 'windowname1')\"/> [<small>Max 685px width of Hot deals banner for default template</small>] </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["best"];
echo " ";
echo $LNG["selling"];
echo "</td>\n   <td class=\"fieldarea\"><input ";
if ($fileserviceDetails["hot"] == "1") {
    echo "checked=checked";
}
echo " name=\"hot\" value=\"1\" type=\"radio\" id=\"hot1\"/><label for=\"hot\">";
echo $LNG["yes"];
echo "</label> <input ";
if ($fileserviceDetails["hot"] == "0" || $fileserviceDetails["hot"] == "") {
    echo "checked=checked";
}
echo " name=\"hot\" value=\"0\" type=\"radio\" id=\"hot0\"/><label for=\"hot0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"> ";
echo $LNG["custom"];
echo " html</td>\n   <td class=\"fieldarea\"><textarea name=\"customhtml\" cols=\"55\" >";
echo $fileserviceDetails["customhtml"];
echo "</textarea></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n   <td class=\"fieldarea\">[<span class=\"textgreen\" style=\"font-weight: bold;\"><a onclick=\"load_subpage('includes/pages/editfileservice.retailinfo.php?id=";
echo $id;
echo "','";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "');\">";
echo $LNG["retail"];
echo " ";
echo $LNG["purchase"];
echo " ";
echo $LNG["information"];
echo "</a></span>]</td>\n</tr>\n\n</tbody>\n</table>\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editfileservice.retailpurchase','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</form>\n\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>