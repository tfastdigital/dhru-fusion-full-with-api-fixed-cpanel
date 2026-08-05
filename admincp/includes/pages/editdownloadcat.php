<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n<ul id=\"tabmenu\"> \n    <li><a ";
if (!$loaddefaultpage) {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab','main2.php?page=downloadmain','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["download"];
echo " ";
echo $LNG["categories"];
echo "</a></li> \n    <li><a  ";
if ($loaddefaultpage == "downloadfiles.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab12','main2.php?page=downloadfiles','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
echo $LNG["download"];
echo "s</a></li>\n    <li><a  ";
if ($loaddefaultpage == "addfile.php") {
    echo " class=\"tabmenu_active\" ";
}
echo "  onclick=\"getContect('#tab13','main2.php?page=addfile','','','#tabcontent',true,'#main_loader');\" id=\"tab13\" > ";
echo $LNG["add"];
echo " ";
echo $LNG["files"];
echo "</a></li>\n  <div style=\"clear: both;\"></div>\n</ul>\n\n<div id=\"tabcontent\">\n";
if ($loaddefaultpage) {
    include $loaddefaultpage;
} else {
    echo "\n";
    $pageid = 181;
    checkPagePermission($pageid);
    require_once ROOTDIR . "/includes/clients.fun.inc.php";
    $cat = mysqli_fetch_assoc(dquery("select * from tbl_downloadcat where `id`='" . $id . "'"));
    echo "  \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
    echo $id;
    echo "\" />\n";
    echo generate_token("form");
    echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"200px\">";
    echo $LNG["category"];
    echo " *</td>\n    <td class=\"fieldarea\"><input name=\"category\"  value=\"";
    echo $cat["category"];
    echo "\" type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\" width=\"200px\">";
    echo $LNG["description"];
    echo " </td>\n    <td class=\"fieldarea\"><textarea name=\"info\" rows=\"15\" style=\" width:100%;\" >";
    echo $cat["info"];
    echo "</textarea></td>\n</tr>\n\n </tbody>\n</table>\n\n<div class=\"fixedbtn\">\n    <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','editdownloadcat','#frm','#notification','true','#main_loader');\"/> \n</div>\n\n</form>\n</div></div>\n </div>\n ";
}
if (!$loaddefaultpage) {
    echo "</div>";
}
echo "    ";
$fileverioncheck = "6.1.0";

?>