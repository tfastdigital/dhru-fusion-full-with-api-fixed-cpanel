<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Testimonial</a></li>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
$pageid = 376;
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["author"];
echo "</th>\n                <th>";
echo $LNG["email"];
echo "</th>\n                <th>";
echo $LNG["comments"];
echo "</th>\n                <th><div align=\"center\">";
echo $LNG["date"];
echo "</div></th>\n                 <th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
if ($approve) {
    checkDemoMode(false);
    $data["status"] = "published";
    $db->update("tbl_testimonial", $data, "id=" . $apprid);
}
if ($delete) {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_testimonial`  WHERE `id`='" . $delid . "'");
}
$comment = dquery("SELECT distinct id,substring(comment,1,100) as comment,date,`tbl_testimonial`.author,email,`tbl_testimonial`.id,`tbl_testimonial`.`status` FROM `tbl_testimonial` WHERE `tbl_testimonial`.`status`='pending'");
while ($row = mysqli_fetch_assoc($comment)) {
    echo "\n<tr>\n<td>";
    echo $row["author"];
    echo "</td>\n<td>";
    echo $row["email"];
    echo "</td>\n<td>";
    echo $row["comment"];
    echo "</td>\n<td align=\"center\">";
    echo $row["date"];
    echo "</td>\n<td align=\"right\">\n<form method=\"post\" title=\"Delete\" style=\"float: right;\"><input type=\"submit\" onclick=\"return confirm('Are you sure want to Remove ?');\" class=\"button deletedata\"  name=\"delete\" value=\"";
    echo $LNG["reject"];
    echo "\" /><input type=\"hidden\" name=\"delid\" value=\"";
    echo $row["id"];
    echo "\" /> </form>\n<form method=\"post\" title=\"Approve\" style=\"float: right;\"><input type=\"submit\" class=\"button approvedata\" name=\"approve\" value=\"";
    echo $LNG["approved"];
    echo "\"/><input type=\"hidden\" name=\"apprid\" value=\"";
    echo $row["id"];
    echo "\" /> </form>\n</td>\n</tr>\n";
}
echo "\n</tbody></table>\n</div></div>";
$fileverioncheck = "6.1.0";

?>