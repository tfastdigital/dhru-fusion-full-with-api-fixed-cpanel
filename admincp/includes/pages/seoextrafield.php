<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo " \n";
if ($change && $ids) {
    foreach ($ids as $v) {
        dquery("UPDATE tbl_seo_links SET status=IF(status=1,0,1) WHERE id='" . $v . "'");
    }
}
if ($delete && $ids) {
    foreach ($ids as $v) {
        dquery("DELETE FROM tbl_seo_links  WHERE id='" . $v . "'");
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\"  border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["seo"];
echo " ";
echo $LNG["url"];
echo " </td>\n    <td class=\"fieldarea\">\n    <input type=\"text\" name=\"link\" value=\"\" />\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["status"];
echo "</td>\n    <td class=\"fieldarea\">\n<input type=\"radio\" name=\"status\"  value=\"1\" id=\"se\" checked=\"\" /> <label for=\"se\">";
echo $LNG["active"];
echo "</label> \n<input type=\"radio\" name=\"status\"  value=\"0\" id=\"sd\" /> <label for=\"sd\">";
echo $LNG["inactive"];
echo "</label>\n    </td>\n</tr>\n\n<tr><td></td><td class=\"fieldarea\"> \n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\" \n onclick=\"SubmitForm ('#btnaddgroup','seoextrafield','#frm','#notification','true','#main_loader');\"/>\n </td></tr>\n</tbody>\n</table>\n</form>\n\n<br />\n\n\n<form id=\"frmcountrylanguage\" name=\"\" method=\"post\">\n\n\n<table id=\"main_tbl\"><thead><tr>\n<th width=\"8\">&nbsp;</th>\n<th width=\"85%\">";
echo $LNG["seo"];
echo " ";
echo $LNG["link"];
echo "</th>\n<th >";
echo $LNG["status"];
echo "</th>\n</tr></thead>\n";
$result = dquery("select * from tbl_seo_links");
while ($row = mysqli_fetch_assoc($result)) {
    echo "\t<tr>\n    <td><input type=\"checkbox\" name=\"ids[";
    echo $row["id"];
    echo "]\" value=\"";
    echo $row["id"];
    echo "\" /></td>\n    <td>";
    echo $row["link"];
    echo "</td>\n    <td>";
    echo $row["status"] == 1 ? "Active" : "Inactive";
    echo "</td>\n    </tr>\n";
}
echo "<tr>\n<td><img src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" /></td>\n<td> <input type=\"submit\" name=\"change\" value=\"";
echo $LNG["change"];
echo " ";
echo $LNG["status"];
echo "\" />\n <input type=\"submit\" class=\"button_remove\" onclick=\"return confirm('Are you sure want to Remove ?');\" name=\"delete\" value=\"";
echo $LNG["remove"];
echo "\" />\n</td>\n<td></td>\n\n</tr>\n</table>\n\n</form>\n\n</div></div>\n";
$fileverioncheck = "6.1.0";

?>