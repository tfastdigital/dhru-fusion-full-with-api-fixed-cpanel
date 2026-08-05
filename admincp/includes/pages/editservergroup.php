<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo " \n<script>\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n";
$pageid = 51;
checkPagePermission($pageid);
$result = dquery("select id,group_name,active,display_order,imagelink,description from tbl_server_group where id=" . $id);
$servergroup = mysqli_fetch_assoc($result);
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"";
echo $servergroup["group_name"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["active"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"active\" value=\"1\" type=\"radio\" id=\"model1\" ";
if ($servergroup["active"] == "1") {
    echo "checked";
}
echo "/><label for=\"model1\">";
echo $LNG["yes"];
echo "</label> <input name=\"active\" value=\"0\" type=\"radio\" id=\"model0\" ";
if ($servergroup["active"] == "0") {
    echo "checked";
}
echo "/><label for=\"model0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td> \n   <td class=\"fieldarea\"><input value=\"";
echo $servergroup["imagelink"];
echo "\" name=\"imagelink\" id=\"imagelink\" type=\"text\"  class=\"txt large\" /> <input class=\"addFromgallery\" value=\"";
echo $LNG["add"];
echo "\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname1')\" type=\"button\"></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td> \n   <td class=\"fieldarea\"><textarea class=\"large textarea\"  name=\"description\" id=\"description\">";
echo $servergroup["description"];
echo "</textarea></td> \n</tr>\n\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','editservergroup','#frm','#notification','true','#main_loader');\"/> \n</div>\n\n</form>\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>