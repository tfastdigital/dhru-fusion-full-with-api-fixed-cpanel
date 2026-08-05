<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 337;
checkPagePermission($pageid);
echo "<style>    \n.form{margin-bottom: 4px !important;}\n</style> \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"master\" value=\"0\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"15%\">";
echo $LNG["name"];
echo " </td>\n    <td><input name=\"name\"  value=\"\" type=\"text\"/></td>\n    <td><strong>";
echo $LNG["or"];
echo " ";
echo $LNG["languagevar"];
echo "</strong></td>\n    <td><input name=\"languagevar\"  value=\"\" type=\"text\"/></td>\n</tr>\n\n<tr>\n    <td>";
echo $LNG["listedin"];
echo " </td>\n    <td colspan=\"3\">\n    <select name=\"groupid\">\n        <option value=\"0\">Main Menu</option>\n        ";
$gr = dquery("SELECT id,name FROM tbl_navigation WHERE groupid='0' and master='0'");
while ($row = mysqli_fetch_assoc($gr)) {
    echo "         <option value=\"";
    echo $row["id"];
    echo "\" >";
    echo $row["name"];
    echo "</option>\n        ";
}
echo "    </select>\n    </td>\n</tr>\n\n<tr>\n    <td>";
echo $LNG["link"];
echo " </td>\n    <td><input name=\"link\"  value=\"\" type=\"text\"/></td>\n    <td>";
echo $LNG["or"];
echo "</td>\n    <td><select name=\"url\">\n    <option value=\"\">Select</option>\n    ";
$sql = dquery("SELECT `id`,`urlname` FROM tbl_cms_pages");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "    <option value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["urlname"];
    echo "</option>\n    ";
}
echo "</select></td>\n</tr>\n\n\n<tr>\n\n    <td>";
echo $LNG["display"];
echo " </td>\n    <td colspan=\"3\">\n    <input type=\"radio\" name=\"display\" id=\"edi\" value=\"1\" checked=\"checked\" /><label for=\"edi\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"display\" id=\"ddi\" value=\"0\"  /><label for=\"ddi\">";
echo $LNG["no"];
echo "</label>    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["login"];
echo " ";
echo $LNG["required"];
echo "</td>\n    <td class=\"fieldarea\" colspan=\"3\">\n    <input type=\"radio\" name=\"req_login\" id=\"rdi\" value=\"1\"  /><label for=\"rdi\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" name=\"req_login\" id=\"rdi\" value=\"0\"  checked=\"\" /><label for=\"rdi\">";
echo $LNG["no"];
echo "</label>    </td>\n</tr>\n</tbody>\n</table> \n\n\n\n<p class=\"fixedbtn\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnoverview\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnoverview','addmenu','#frm','#notification','true','#main_loader');\"/> </p>\n\n</form>\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>