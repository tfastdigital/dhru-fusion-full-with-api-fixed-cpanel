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
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($dels) {
    dquery("delete from tbl_survey_detail where id='" . $dels . "'");
}
$sql = dquery("select * from  tbl_survey_detail where srid='" . $id . "'");
echo "\n<table id=\"main_tbl\" width=\"100%\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["date"];
echo "</th>\n                <th>";
echo $LNG["user"];
echo "</th>\n                <th align=\"center\">";
echo $LNG["ip"];
echo "</th>\n                <th style=\"text-align: right !important; margin-left: 20px !important;\">";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody> \n";
if ($delete) {
    dquery("DELETE FROM `tbl_review`  WHERE `id`='" . $delid . "'");
    while ($row = mysqli_fetch_assoc($sql)) {
    }
    echo "\n</tbody></table>\n</div></div>";
    $fileverioncheck = "6.1.0";
}
echo "\n<tr>\n<td>";
echo $row["date"];
echo "</td>\n<td>";
echo $row["name"];
echo " [";
echo $row["email"];
echo "]</td>\n<td><a href=\"javascript: load_subpage('";
echo $config["ip_location"];
echo $row["ip"];
echo "','IP Location')\">\n";
echo $row["ip"];
echo "</a></td>\n<td align=\"right\"><a class='default_dg_a2 editdata' \nhref=\"javascript: redirectedit('viewsurvey','";
echo $row["id"];
echo "')\">\n";
echo $LNG["view"];
echo "</a>\n&nbsp;\n<a class='default_dg_a2 deletedata'  onclick=\"return confirm('Are you sure want to remove ?');\"\nhref=\"javascript: redirectedit('viewopinion','";
echo $id;
echo "&dels=";
echo $row["id"];
echo "')\">\n";
echo $LNG["delete"];
echo "</a>\n</td>\n</tr>\n";

?>