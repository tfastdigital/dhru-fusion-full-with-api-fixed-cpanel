<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "  \n";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
require_once "includes/3rdparty/editor/editor.php";
echo " \n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
$ban = mysqli_fetch_assoc(dquery("SELECT  * FROM `tbl_advertisement_banners` WHERE `id`='" . $_GET["edit"] . "' "));
echo "<div id=\"tabcontent\">\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script language=\"JavaScript\">\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n\n<form method=\"post\" id=\"frm\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $_GET["edit"];
echo "\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"90%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["bannerimg"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"text\" name=\"banner\" id=\"banner\" value=\"";
echo $ban["img"];
echo "\"/> <input type=\"button\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onclick=\"newWindow('includes/gallery.php?id=banner', 'windowname1')\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["title"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"title\"  value=\"";
echo $ban["img_title"];
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["info"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"info\" value=\"";
echo $ban["info"];
echo "\"/>\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["readmorelink"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"readmore\" value=\"";
echo $ban["readmore_link"];
echo "\" />\n    </span></td>\n</tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editadvertisementbanner','#frm','#notification','true','#main_loader');\"/>\n</p>\n</form>\n</div></div>\n </div>";
$fileverioncheck = "6.1.0";

?>