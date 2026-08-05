<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n<ul id=\"tabmenu\"> \n     <li><a onclick=\"getContect('#tab','main2.php?page=knowledgebase','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["listknowledgebase"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab12','main2.php?page=addknowledgebase','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["addknowledgebase"];
echo "</a></li>\n    <li><a class=\"tabmenu_active\"  onclick=\"getContect('#tab2','main2.php?page=knowledgebasecatlist','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
echo $LNG["view"];
echo " ";
echo $LNG["category"];
echo "</a></li> \n    <li><a onclick=\"getContect('#tab3','main2.php?page=knowledgebasecatadd','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a></li>\n    \n    <div style=\"clear: both;\"></div>\n</ul>  \n\n<div id=\"tabcontent\">\n";
$pageid = 181;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$cat = mysqli_fetch_assoc(dquery("select * from tbl_knowledgebasecat\n where `id`='" . $id . "'"));
echo "    <script>\n        function newWindow(file,window)\n        {   msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n            if (msgWindow.opener == null) msgWindow.opener = self;\n        }\n    </script>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"200px\">";
echo $LNG["category"];
echo " *</td>\n    <td class=\"fieldarea\"><input name=\"category\"  value=\"";
echo $cat["category"];
echo "\" type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"200px\">";
echo $LNG["description"];
echo " </td>\n    <td class=\"fieldarea\"><textarea name=\"info\" \n    rows=\"10\" cols=\"85\" >";
echo $cat["info"];
echo "</textarea></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["iconlink"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"image\" id=\"iconlink\" value=\"";
echo $cat["image"];
echo "\" type=\"text\"  class=\"txt\"/> <input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["from"];
echo " ";
echo $LNG["gallery"];
echo "\" type=\"button\" class=\"addFromgallery\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\"/></td>\n</tr>\n \n</tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','editknowledgebasecat','#frm','#notification','true','#main_loader');\"/>\n</div>\n\n</form>\n</div></div>\n </div>";
$fileverioncheck = "6.1.0";

?>