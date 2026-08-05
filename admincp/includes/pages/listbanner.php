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
echo "<link rel=\"stylesheet\" media=\"screen\" type=\"text/css\" href=\"../includes/colorpicker/css/colorpicker.css\" />\n<script type=\"text/javascript\" src=\"../includes/colorpicker/js/colorpicker.js\"></script>\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n    \$(document).ready(function() {\n    \t\$('#main_tbl').tableDnD({\n    \t    onDrop: function(table, row) {\n    \t       var serialized= \$.tableDnD.serialize();\n    \t        \$.ajax({\n    \t\t\t\ttype: 'POST',\n    \t\t\t\turl: \"includes/pages/banner.order.save.php\",\n    \t\t\t\tdata: serialized,\n    \t\t\t\tsuccess: function(data) {\n    \t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n    \t\t\t\t     \$(\"#notification1\").html(data).show();\n    \t\t\t\t}\n    \t\t\t});\n    \t    }\n    \t});\n    });\n</script>\n\n\n<div id=\"notification\"></div>\n<div id=\"content\" style=\"width: 100%;!important \">\n\n\n<div  class=\"groupstabes\" >\n<h2>\n<span class=\"groupstabesheadertext\">";
echo $LNG["list"];
echo " ";
echo $LNG["banner"];
echo "</span>\n</h2>\n\n\n<table id=\"main_tbl\" >\n<thead>\n  <tr class='nodrag'>\n        <th>";
echo $LNG["title"];
echo "</th>\n        <th>";
echo $LNG["background"];
echo " </th>\n\n        <th>";
echo $LNG["action"];
echo "</th>\n  </tr>\n</thead>\n<tbody>\n\n\n";
if (isset($delete)) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>This function not enabled in demo mode .</div>";
    } else {
        dquery("delete from tbl_bannerslider_banners where id='" . $id . "'");
    }
}
$bann = dquery("SELECT * FROM tbl_bannerslider_banners where store='0' \nORDER BY sort");
while ($row = mysqli_fetch_assoc($bann)) {
    echo "\n\n    <tr  id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n        <td>";
    echo $row["img_title"];
    echo "</td>\n        <td>";
    echo $row["img"];
    echo "</td>\n\n        <td>\n        <div style=\"float: right;\" >\n            <form title=\"edit\" action=\"javascript:load_subpage('main2.php?page=editbanner&edit=";
    echo $row["id"];
    echo "','";
    echo $LNG["indexbanner"];
    echo "');\" method=\"post\" style=\"float:left;\">\n                <input class=\"button editdata\" type=\"submit\"  name=\"edit\" value=\"";
    echo $LNG["edit"];
    echo "\" />\n            </form>\n        </div>\n         <div style=\"float: right;\">\n            <form title=\"delete\" method=\"post\" onsubmit=\"return confirm('Are you sure want to remove Banner?');\">\n                <input type=\"hidden\" name=\"id\" value=\"";
    echo $row["id"];
    echo "\" />\n                <input type=\"hidden\" name=\"laoddefaultpage\" value=\"listbanner.php\" />\n                <input type=\"submit\"  class=\"button deletedata\"    name=\"delete\" value=\"";
    echo $LNG["delete"];
    echo "\" />\n            </form>\n        </div>\n         </td>\n\n    </tr>\n\n    ";
}
echo "\n</tbody></table>\n\n<br /><br /><br />\n";
$fileverioncheck = "6.1.0";

?>