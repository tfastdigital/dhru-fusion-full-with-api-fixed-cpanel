<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n<script>\nfunction newWindow(file,window)\n{   msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n}\n</script>\n";
$pageid = 71;
checkPagePermission($pageid);
$result = dquery("select id,group_name,active,display_order,imagelink,\ndescription from tbl_file_group where id=" . $id);
$filegroup = mysqli_fetch_assoc($result);
echo " \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"";
echo $filegroup["group_name"];
echo "\" type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["active"];
echo "</td>\n    <td class=\"fieldarea\"><input name=\"active\" value=\"1\" type=\"radio\" id=\"model1\" ";
if ($filegroup["active"] == "1") {
    echo "checked";
}
echo "/><label for=\"model1\">";
echo $LNG["yes"];
echo "</label> <input name=\"active\" value=\"0\" type=\"radio\" id=\"model0\" ";
if ($filegroup["active"] == "0") {
    echo "checked";
}
echo "/><label for=\"model0\">";
echo $LNG["no"];
echo "</label></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td> \n   <td class=\"fieldarea\"><input value=\"";
echo $filegroup["imagelink"];
echo "\" name=\"imagelink\" id=\"imagelink\" type=\"text\" /> <input value=\"";
echo $LNG["add"];
echo "\" name=\"add\" class=\"addFromgallery\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname1')\" type=\"button\" /></td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td> \n   <td class=\"fieldarea\"><textarea class=\"textarea large\"  \n    name=\"description\" id=\"description\">";
echo $filegroup["description"];
echo "</textarea></td> \n</tr>\n\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" \nclass=\"btn save\" type=\"button\"  \nonclick=\"SubmitForm('#btnoverview','editfilegroup','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n</div></div>";
$fileverioncheck = "6.1.0";

?>