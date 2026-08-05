<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 495;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"notification1\"> </div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\nfunction setDeleted(dos){\n    if(confirm(\"Are you sure want to remove\")){\n          redirectedit('catlog',dos+'&delete='+dos+'&defaultloadpage=homepagegroup.php');\n    }\n}\n\$(document).ready(function() {\n\t\$('#main_tbl').tableDnD({\n\t    onDrop: function(table, row) {\n\t       var serialized= \$.tableDnD.serialize();\n\t        \$.ajax({\n\t\t\t\ttype: 'POST',\n\t\t\t\turl: \"includes/pages/homepage.order.save.php\",\n\t\t\t\tdata: serialized,\n\t\t\t\tsuccess: function(data) {\n\t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t\t}\n\t\t\t});\n\t    }\n\t});\n});\n</script>\n";
if ($delete) {
    checkDemoMode(false);
    dquery("delete from tbl_homepagegroup where id='" . $delete . "'");
}
if ($add && $group) {
    checkDemoMode(false);
    if (!mysqli_num_rows(dquery("select id from tbl_homepagegroup where `group`='" . $group . "'"))) {
        $data["group"] = $group;
        $data["mid"] = $mid;
        $db->insert("tbl_homepagegroup", $data);
        $data = NULL;
        echo "<div id='notification1' class='successbox'>Group added successfully</div>";
    } else {
        echo "<div id='notification1' class='errorbox'>This group is already exists</div>";
    }
}
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Home Page Grouping</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<form method=\"post\">\n    <table id=\"main_tbl\" >\n                <thead>\n                  <tr>\n                    <th >";
echo $LNG["group"];
echo " </th>\n                      <th >Parent Group </th>\n                    <th ><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n                  </tr>\n                </thead>\n                <tbody> \n    <tr>\n        <td><input type=\"hidden\" name=\"defaultloadpage\" value=\"homepagegroup.php\" /><input name=\"group\"  value=\"\" type=\"text\" /></td>\n        <td>\n\n            <select name=\"mid\">\n                <option value=\"\">Select</option>\n                ";
$qs = dquery("select * from tbl_homepagegroup where id!='" . $id . "' and mid=0");
while ($rs = mysqli_fetch_assoc($qs)) {
    $selected = "";
    if ($rs["id"] == $rs["mid"]) {
        $selected = "selected";
    }
    echo "                    <option ";
    echo $selected;
    echo " value=\"";
    echo $rs["id"];
    echo "\">";
    echo $rs["group"];
    echo "</option>\n                    ";
}
echo "            </select>\n        </td>\n        <td> <input name=\"add\" class=\"btn add\" type=\"submit\" value=\"";
echo $LNG["add"];
echo "\"/></td>\n    </tr>            \n    ";
$s = dquery("select id,`group` from tbl_homepagegroup ORDER BY sort");
while ($row = mysqli_fetch_assoc($s)) {
    echo "    <tr id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n\n    <td>";
    echo $row["group"];
    echo "</td>  <td>\n\n        </td>\n    <td align=\"right\">\n    <a href=\"javascript:load_subpage('main2.php?page=catlog&id=";
    echo $row["id"];
    echo "&defaultloadpage=edithomepagegroup.php','Edit');\" class=\"editdata\">";
    echo $LNG["edit"];
    echo "</a>\n    <a href=\"javascript: setDeleted(";
    echo $row["id"];
    echo ");\" class=\"deletedata\">";
    echo $LNG["delete"];
    echo "</a>\n    </td>\n    </tr>\n    ";
}
echo " \n         \n    </tbody>\n    </table> \n</form>  \n</div>         \n</div></div></div>";
$fileverioncheck = "6.1.0";

?>