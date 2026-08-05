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
require ROOTDIR . "/includes/clients.fun.inc.php";
if ($id) {
    dquery("update tbl_review SET status=(IF(status=1,0,1)) where md5(id)='" . $id . "'");
}
echo "  \n<script src=\"../includes/js/rating.js\" type=\"text/javascript\"></script>\n<link rel=\"stylesheet\" href=\"../includes/css/rating.css\" type=\"text/css\"/>\n<table id=\"main_tbl\" width=\"100%\">\n            <thead>\n              <tr>\n                <th width=\"150px\">";
echo $LNG["service"];
echo "/";
echo $LNG["product"];
echo "</th>\n                <th>";
echo $LNG["name"];
echo "</th>\n                <th width=\"90px\">";
echo $LNG["email"];
echo "</th>\n                <th width=\"90px\">";
echo $LNG["date"];
echo "</th>\n                <th>";
echo $LNG["comments"];
echo "</th>\n                <th width=\"100px\">";
echo $LNG["ratings"];
echo " / 5</th>\n                <th  width=\"230px\">";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody> \n            \n            \n";
if ($approve) {
    checkDemoMode(false);
    $data["status"] = "1";
    $db->update("tbl_review", $data, "id=" . $apprid);
}
if ($delete) {
    checkDemoMode(false);
    dquery("DELETE FROM `tbl_review`  WHERE `id`='" . $delid . "'");
}
$comment = dquery("SELECT * from tbl_review where supplier='" . $id . "'");
while ($row = mysqli_fetch_assoc($comment)) {
    echo "\n<tr>\n<td>";
    if ($row["sid"]) {
        $sql = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei where id='" . $row["sid"] . "'"));
    } else {
        $sql = mysqli_fetch_assoc(dquery("select service_name from tbl_products where id='" . $row["pid"] . "'"));
    }
    echo $sql["service_name"];
    echo "</td>\n<td>";
    echo $row["name"];
    echo "</td>\n<td>";
    echo $row["email"];
    echo "</td>\n<td>";
    echo $row["date"];
    echo "</td>\n<td><textarea style=\"width: 200px !important\" rows=\"3\">";
    echo $row["comment"];
    echo "</textarea></td>\n<td align=\"left\">\n";
    echo $row["rate"];
    echo "<div id=\"allrate";
    echo $row["id"];
    echo "\" class=\"ratinga\">&nbsp;</div>\n</td>\n<td align=\"right\">\n<form method=\"post\" style=\"float: right;\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editsupplier.feedback.php\" /><input type=\"submit\" class=\"button deletedata\" onclick=\"return confirm('Are you sure want to remove Feedback ?');\" class=\"button_remove\" name=\"delete\" value=\"";
    echo $LNG["delete"];
    echo "\" /><input type=\"hidden\" name=\"delid\" value=\"";
    echo $row["id"];
    echo "\" /> </form>&nbsp;&nbsp;&nbsp;\n";
    if (!$row["status"]) {
        echo "<form method=\"post\" style=\"float: right;\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editsupplier.feedback.php\" /><input class=\"button approvedata\" type=\"submit\" name=\"approve\" value=\"";
        echo $LNG["approved"];
        echo "\" /><input type=\"hidden\" name=\"apprid\" value=\"";
        echo $row["id"];
        echo "\" /> </form> &nbsp;&nbsp;&nbsp;";
    }
    echo "<form method=\"post\" style=\"float: right;\"><input type=\"hidden\" name=\"defaultloadpage\" value=\"editsupplier.feedback.php\" /><input class=\"button editdata\" type=\"button\" onclick=\"javascript:load_subpage('includes/pages/editreview.php?id=";
    echo $row["id"];
    echo "', '";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["review"];
    echo "'); return false;\" value=\"";
    echo $LNG["edit"];
    echo "\" /></form>&nbsp;&nbsp;&nbsp;\n</td>\n</tr>\n";
}
echo "\n</tbody></table>\n</div></div>";
$fileverioncheck = "6.1.0";

?>