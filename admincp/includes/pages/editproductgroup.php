<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "  \n";
$pageid = 355;
checkPagePermission($pageid);
$result = dquery("select id,mid,seotitle,seodescription,group_name,active,display_order,imagelink,iconlink,description from tbl_product_group where id=" . $id);
$imeigroup = mysqli_fetch_assoc($result);
include ROOTDIR . "/includes/products.fun.php";
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "pgroup", $imeigroup["mid"]);
echo " \n\n<script language=\"javascript\" type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
include_once "includes/3rdparty/editor/editor.php";
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<script>\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $imeigroup["group_name"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["groupname"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"groupname\"  value=\"";
echo $imeigroup["group_name"];
echo "\" type=\"text\"  class=\"txt medium\"/></td>\n</tr>\n \n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["listedingroup"];
echo " </td> \n    <td class=\"fieldarea\">\n    ";
echo $grp;
echo "    </td> \n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
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
echo "</label></td>\n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["sorting"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"order\"  value=\"";
echo $imeigroup["display_order"];
echo "\" type=\"text\"  class=\"txt small\"/></td>\n</tr>\n-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["navigation"];
echo " ";
echo $LNG["image"];
echo "</td>\n   <td class=\"fieldarea\"><input value=\"";
echo $imeigroup["imagelink"];
echo "\" name=\"imagelink\" id=\"imagelink\" type=\"text\"  class=\"txt medium\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=imagelink', 'windowname2')\" type=\"button\" class=\"addFromgallery\" /></td> \n</tr>\n<!--\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["icon"];
echo " ";
echo $LNG["link"];
echo "</td> \n   <td class=\"fieldarea\"><input value=\"";
echo $imeigroup["iconlink"];
echo "\" name=\"iconlink\" id=\"iconlink\" type=\"text\"  class=\"txt medium\" /> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\" type=\"button\" class=\"addFromgallery\" /></td> \n</tr>\n-->\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["seo"];
echo " ";
echo $LNG["page"];
echo " ";
echo $LNG["title"];
echo "</td>\n    <td class=\"fieldarea\"><input value=\"";
echo $imeigroup["seotitle"];
echo "\" name=\"seotitle\" id=\"seotitle\" type=\"text\"  class=\"txt medium\" /> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["seo"];
echo " ";
echo $LNG["description"];
echo "</td>\n    <td class=\"fieldarea\"><input value=\"";
echo $imeigroup["seodescription"];
echo "\" name=\"seodescription\" id=\"seodescription\" type=\"text\"  class=\"txt medium\" /> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "</td> \n   <td class=\"fieldarea\">\n   <input type=\"hidden\" name=\"description\" id=\"description\"/>\n   <textarea  class=\"textarea large\" name=\"message\" id=\"message\" >";
echo $imeigroup["description"];
echo "</textarea></td> \n</tr>\n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnoverview\" \n    class=\"btn save\" type=\"button\"  onclick=\"javascript:document.getElementById('description').value=tinyMCE.get('message').getContent();SubmitForm ('#btnoverview','editproductgroup','#frm','#notification','true','#main_loader');\"/> \n</div>\n\n</form>\n</div></div></div></div>\n ";
$fileverioncheck = "6.1.0";

?>