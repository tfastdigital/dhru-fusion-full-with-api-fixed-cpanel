<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n\n</style>\n";
include_once "includes/3rdparty/editor/editor.php";
$pageid = 259;
checkPagePermission($pageid);
$result = dquery("select id,hideguest,showonhomepage,disabletelegram,group_name,active,display_order,imagelink,description from tbl_imei_group where id=" . $id);
$imeigroup = mysqli_fetch_assoc($result);
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<script>\n function newWindow(file,window)\n { msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"";
echo $imeigroup["group_name"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["active"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"active\" value=\"1\" type=\"radio\" id=\"model1\" ";
if ($imeigroup["active"] == "1") {
    echo "checked";
}
echo "/><label for=\"model1\">";
echo $LNG["yes"];
echo "</label> <input name=\"active\" value=\"0\" type=\"radio\" id=\"model0\" ";
if ($imeigroup["active"] == "0") {
    echo "checked";
}
echo "/><label for=\"model0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["hide"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["visitors"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input name=\"hideguest\" value=\"1\" type=\"radio\"\n               id=\"hideguest\" ";
if ($imeigroup["hideguest"] == "1") {
    echo "checked";
}
echo "/><label for=\"hideguest\">";
echo $LNG["yes"];
echo "</label>\n        <input name=\"hideguest\" value=\"0\" type=\"radio\" id=\"hideguestl0\" ";
if ($imeigroup["hideguest"] == "0") {
    echo "checked";
}
echo "/><label for=\"hideguestl0\">";
echo $LNG["no"];
echo "</label>\n        <small>";
echo $LNG["do"];
echo " ";
echo $LNG["not"];
echo " ";
echo $LNG["display"];
echo " ";
echo $LNG["in"];
echo " ";
echo $LNG["wholesale"];
echo " ";
echo $LNG["price"];
echo " ";
echo $LNG["without"];
echo "  ";
echo $LNG["login"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">Telegram</td>\n    <td class=\"fieldarea\">\n        <input name=\"disabletelegram\" value=\"0\" type=\"radio\"\n               id=\"allowtele\" ";
if ($imeigroup["disabletelegram"] == "0") {
    echo "checked";
}
echo "/><label for=\"allowtele\">";
echo $LNG["yes"];
echo "</label>\n        <input name=\"disabletelegram\" value=\"1\" type=\"radio\" id=\"distele\" ";
if ($imeigroup["disabletelegram"] == "1") {
    echo "checked";
}
echo "/><label for=\"distele\">";
echo $LNG["no"];
echo "</label>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td> \n   <td class=\"fieldarea\"><input value=\"";
echo $imeigroup["imagelink"];
echo "\" name=\"imagelink\" id=\"imagelink\" type=\"text\"  class=\"txt medium\" /> <input value=\"";
echo $LNG["add"];
echo "\" name=\"add\" class=\"addFromgallery\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname1')\" type=\"button\"></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td> \n   <td class=\"fieldarea\">\n       <input type=\"hidden\" name=\"description\" id=\"tinyvalue\" />\n       <textarea class=\"textarea large\" name=\"infos\" id=\"description\">";
echo $imeigroup["description"];
echo "</textarea></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["show"];
echo " ";
echo $LNG["on"];
echo " ";
echo $LNG["home"];
echo " ";
echo $LNG["page"];
echo "</td>\n    <td class=\"fieldarea\">\n        <input   ";
if ($imeigroup["showonhomepage"] == "1") {
    echo "checked=checked";
}
echo " name=\"showonhomepage\" value=\"1\" type=\"checkbox\" class=\"onoff\n        {labelOn: 'Enable',\n        labelOff: 'Disable'}\" id=\"fred\"/><label  for=\"fred\"></label>\n    </td>\n</tr>\n\n\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"\nonclick=\"document.getElementById('tinyvalue').value=tinyMCE.get('description').getContent();SubmitForm ('#btnoverview','editimeigroup','#frm','#notification','true','#main_loader');\"\n    />\n</div>\n\n</form>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>