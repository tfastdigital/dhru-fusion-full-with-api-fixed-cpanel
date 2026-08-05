<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Comments</a></li>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
$pageid = 104;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
echo "<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\">\n            <thead>\n              <tr>\n                <th>";
echo $LNG["author"];
echo "</th>\n                <th>";
echo $LNG["title"];
echo "</th>\n                <th>";
echo $LNG["email"];
echo "</th>\n                <th>";
echo $LNG["authorurl"];
echo "</th>\n                <th><div align=\"center\">";
echo $LNG["ip"];
echo "</div></th>\n                 <th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
if ($approve) {
    checkDemoMode(false);
    $data["status"] = "approved";
    $db->update("tbl_blogcomments", $data, "id=" . $apprid);
}
if ($delete) {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_blogcomments`  WHERE `id`='" . $delid . "'");
}
$comment = dquery("SELECT distinct title,`tbl_blogcomments`.author,email,authorurl,ip,`tbl_blogcomments`.id,`tbl_blogcomments`.`status` FROM `tbl_blogcomments`,tbl_blogposts WHERE `tbl_blogcomments`.`status`='pending' and `tbl_blogcomments`.post=tbl_blogposts.id");
while ($row = mysqli_fetch_assoc($comment)) {
    echo "\n<tr>\n<td>";
    echo $row["author"];
    echo "</td>\n<td>";
    echo $row["title"];
    echo "</td>\n<td>";
    echo $row["email"];
    echo "</td>\n<td>";
    echo $row["authorurl"];
    echo "</td>\n<td align=\"center\"><a\n href=\"javascript:load_subpage('";
    echo $config["ip_location"] . "" . $row["ip"];
    echo "', '";
    echo $LNG["geo"];
    echo " ";
    echo $LNG["ip"];
    echo " ";
    echo $LNG["location"];
    echo "');\">";
    echo $row["ip"];
    echo "</a></td>\n<td align=\"right\">\n";
    if ($row["status"] == "pending") {
        echo "<form method=\"post\" title=\"Delete\" style=\"float: right;\"><input type=\"submit\" class=\"button deletedata\" name=\"delete\" onclick=\"return confirm('Are you sure want to remove Comments ?');\" value=\"";
        echo $LNG["delete"];
        echo "\" /><input type=\"hidden\" name=\"delid\" value=\"";
        echo $row["id"];
        echo "\" /> </form>\n<form method=\"post\" title=\"Edit\" style=\"float: right;\"><input type=\"button\" class=\"button editdata\" onclick=\"javascript:load_subpage('main2.php?page=editblogauthor&id=";
        echo $row["id"];
        echo "', '";
        echo $LNG["edit"];
        echo " ";
        echo $LNG["comments"];
        echo "');\" value=\"";
        echo $LNG["edit"];
        echo "\" /></form>\n<form method=\"post\" title=\"Approve\" style=\"float: right;\"><input type=\"submit\" class=\"button approvedata\" name=\"approve\" value=\"";
        echo $LNG["approved"];
        echo "\" /><input type=\"hidden\" name=\"apprid\" value=\"";
        echo $row["id"];
        echo "\" /> </form> ";
    }
    echo "</td>\n</tr>\n";
}
echo "\n</tbody></table>\n</div></div>";
$fileverioncheck = "6.1.0";

?>