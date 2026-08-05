<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
$pageid = 481;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
if ($approve) {
    checkDemoMode(false);
    $data["status"] = "1";
    $db->update("tbl_review", $data, "id=" . $apprid);
}
echo "<table id=\"main_tbl\" width=\"100%\">\n            <thead>\n              <tr>\n                <th width=\"10%\">";
echo $LNG["name"];
echo "</th>\n                <th width=\"10%\">";
echo $LNG["email"];
echo "</th>\n                <th width=\"7%\">";
echo $LNG["date"];
echo "</th>\n                <th width=\"20%\">";
echo $LNG["comments"];
echo "</th>\n                <th width=\"10%\">";
echo $LNG["ratings"];
echo " / 5</th>\n                <th width=\"30%\"><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
if ($delete) {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_review`  WHERE `id`='" . $delid . "'");
}
if ($status == "pending") {
    $comment = dquery("SELECT * from tbl_review where  lid!='0' and status='0'");
    while ($row = mysqli_fetch_assoc($comment)) {
    }
    echo "\n</tbody></table>\n</div></div>";
    $fileverioncheck = "6.1.0";
} else {
    $comment = dquery("SELECT * from tbl_review where  lid='" . $id . "' order by status");
}
echo "\n<tr>\n\n<td>";
echo $row["name"];
echo "</td>\n<td>";
echo $row["email"];
echo "</td>\n<td>";
echo $row["date"];
echo "</td>\n<td><textarea style=\"width:180px\">";
echo $row["comment"];
echo "</textarea></td>\n<td>";
echo $row["rate"];
echo "</td>\n<td ><div align=\"left\">\n\n<form method=\"post\" title=\"delete\" style=\"float: right;\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editserverservice.review.php\" /><input type=\"submit\" class=\"button deletedata\" name=\"delete\" onclick=\"return confirm('Are you sure want to remove Review? ');\" value=\"";
echo $LNG["delete"];
echo "\" /><input type=\"hidden\" name=\"delid\" value=\"";
echo $row["id"];
echo "\" /> </form>&nbsp;&nbsp;&nbsp;\n<form method=\"post\" title=\"edit\" style=\"float: right;\"><input type=\"button\" class=\"button editdata\" onclick=\"load_subpage('includes/pages/editreview.php?id=";
echo $row["id"];
echo "', '";
echo $LNG["edit"];
echo " ";
echo $LNG["customer"];
echo " ";
echo $LNG["review"];
echo "');\" value=\"";
echo $LNG["edit"];
echo "\" /></form>&nbsp;&nbsp;&nbsp;\n";
if (!$row["status"]) {
    echo "<form method=\"post\" title=\"approve\" style=\"float: right;\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editserverservice.review.php\" /><input type=\"submit\" class=\"button approvedata\" name=\"approve\" value=\"";
    echo $LNG["approved"];
    echo "\" /><input type=\"hidden\" name=\"apprid\" value=\"";
    echo $row["id"];
    echo "\" /> </form> &nbsp;&nbsp;&nbsp;\n";
}
echo "</div>\n</td>\n</tr>\n";

?>