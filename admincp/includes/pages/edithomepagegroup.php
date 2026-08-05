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
if ($edit) {
    checkDemoMode(false);
    $data["group"] = $group;
    $data["viewmore"] = $viewmore;
    $data["mid"] = $mid;
    $db->update("tbl_homepagegroup", $data, "id='" . $id . "'");
    $data = NULL;
    echo "<div id='notification1' class='successbox'>Group updated successfully</div>";
}
if ($id) {
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_homepagegroup WHERE id='" . $id . "'"));
}
include ROOTDIR . "/includes/products.fun.php";
$group = getProductGroup();
$grp = buildProductGrou(getProductGroupArray(), "", "dropdown", "viewmore", $sql["viewmore"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Edit ";
echo $sql["group"];
echo " Group</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form method=\"post\">\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n<input type=\"hidden\" name=\"defaultloadpage\" value=\"edithomepagegroup.php\" />\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">Parent ";
echo $LNG["group"];
echo " </td>\n    <td class=\"fieldarea\">\n        <select name=\"mid\">\n            <option value=\"\">Select</option>\n            ";
$qs = dquery("select * from tbl_homepagegroup where id!='" . $id . "' and mid=0");
while ($rs = mysqli_fetch_assoc($qs)) {
    $selected = "";
    if ($rs["id"] == $rs["mid"]) {
        $selected = "selected";
    }
    echo "                 <option ";
    echo $selected;
    echo " value=\"";
    echo $rs["id"];
    echo "\">";
    echo $rs["group"];
    echo "</option>\n                 ";
}
echo "        </select>\n    </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["group"];
echo " </td>\n    <td class=\"fieldarea\"><input name=\"group\"  value=\"";
echo $sql["group"];
echo "\" type=\"text\"/></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["viewmore"];
echo " </td>\n    <td  class=\"fieldarea\">";
echo $grp;
echo "</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td ><input name=\"edit\" class=\"btn save\" type=\"submit\" value=\"";
echo $LNG["save"];
echo "\"/></td>\n</tr>\n</tbody>\n</table>\n</form>\n\n</div></div>\n\n\n<br />\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $sql["group"];
echo " Items</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n    \n    <a style=\"float: right;\" \n    onclick=\"load_subpage('main2.php?page=edithomepage.list&id=";
echo $id;
echo "','";
echo $LNG["add"];
echo $LNG["products"];
echo "');\"> ";
echo $LNG["add"];
echo " ";
echo $LNG["items"];
echo " ";
echo $LNG["in"];
echo " ";
echo $LNG["group"];
echo " </a>\n\n\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n\n<table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
echo $LNG["item"];
echo "</th>\n                <th><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n              </tr>\n            </thead>\n            <tbody> \n";
if ($remove) {
    $sql = mysqli_fetch_assoc(dquery("select pid from tbl_homepagegroup where id='" . $id . "'"));
    $prod = explode(",", $sql["pid"]);
    foreach ($prod as $k => $v) {
        if ($v == $remove) {
            unset($prod[$k]);
        }
    }
    $prod = implode(",", $prod);
    dquery("update tbl_homepagegroup set pid='" . $prod . "' where id='" . $id . "'");
}
$flag = false;
$sql = mysqli_fetch_assoc(dquery("select pid from tbl_homepagegroup where id='" . $id . "'"));
$bun = explode(",", $sql["pid"]);
foreach ($bun as $b) {
    if ($b) {
        $flag = true;
        $row = mysqli_fetch_assoc(dquery("select service_name,credit from tbl_products where id='" . $b . "'"));
        echo "<tr>\n<td>";
        echo $row["service_name"];
        echo "</td>\n<td align=\"right\"><a class=\"deletedata\" onclick=\"javascript: return confirm('Are you sure want to remove?');\" href=\"javascript: redirectedit('catlog','";
        echo $id;
        echo "&remove=";
        echo $b;
        echo "&defaultloadpage=edithomepagegroup.php')\">";
        echo $LNG["remove"];
        echo "</a></td>\n</tr>\n";
    }
}
echo "      \n</tbody>\n</table>   \n</div> </div>         \n</div></div>";
$fileverioncheck = "6.1.0";

?>