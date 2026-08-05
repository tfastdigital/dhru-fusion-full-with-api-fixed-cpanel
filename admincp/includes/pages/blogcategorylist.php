<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($delete) {
    include "blog.head.php";
    echo "<div id='tabcontent'>";
}
$pageid = 106;
checkPagePermission($pageid);
if ($category && $save) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    $data["name"] = $category;
    $b = mysqli_fetch_assoc(dquery("SELECT sort FROM tbl_blogcats ORDER BY sort DESC"));
    $data["sort"] = $b["sort"] + 1;
    if ($db->insert("tbl_blogcats", $data)) {
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
echo "<div id=\"content\"><div id=\"content_padded\">\n<div id=\"notification\"> </div>\n<div id=\"notification1\"></div>\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$(document).ready(function() {\n\t\$('#main_tbl').tableDnD({\n\t    onDrop: function(table, row) {\n\t       var serialized= \$.tableDnD.serialize();\n\t        \$.ajax({\n\t\t\t\ttype: 'POST',\n\t\t\t\turl: \"includes/pages/blogcat.order.save.php\",\n\t\t\t\tdata: serialized,\n\t\t\t\tsuccess: function(data) {\n\t\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t\t}\n\t\t\t});\n\t    }\n\t});\n});\n</script>\n<form  method=\"post\">  \n\n<table id=\"main_tbl\" >\n<thead>\n  <tr class='nodrag'>\n    <th>";
echo $LNG["name"];
echo "</th>                    \n    <th><div align=\"right\">";
echo $LNG["action"];
echo "</div> </th>\n  </tr>\n</thead>\n<tbody> \n\n<tr class=\"\"> \n    <input type=\"hidden\"  name=\"pages\" value=\"blogcategorylist.php\" />\n    ";
echo generate_token("form");
echo "    <td><input name=\"category\"  value=\"\" type=\"text\"/></td>\n    <td><input value=\"";
echo $LNG["add"];
echo "\"  name=\"save\"  type=\"submit\" />\n    </td>\n\n</tr>            \n\n           \n";
include_once "includes/fun.inc.php";
$admin_template = $config["admin_template"];
global $admin_template;
if ($id) {
    $sort = mysqli_fetch_assoc(dquery("SELECT `sort` FROM tbl_blogcats WHERE `id`='" . $id . "'"));
}
if ($up && $id) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    $ord = $sort["sort"] - 1;
    dquery("UPDATE tbl_blogcats SET `sort`=`sort`-1 WHERE `id`='" . $id . "'");
    dquery("UPDATE tbl_blogcats SET `sort`=`sort`+1 WHERE `id`!='" . $id . "' AND `sort`='" . $ord . "'");
}
if ($down && $id) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    $ord = $sort["sort"] + 1;
    dquery("UPDATE tbl_blogcats SET `sort`=`sort`+1 WHERE `id`='" . $id . "'");
    dquery("UPDATE tbl_blogcats SET `sort`=`sort`-1 WHERE `id`!='" . $id . "' AND `sort`='" . $ord . "'");
}
if ($delete && $id) {
    if ($DEMOMODE) {
        echo "<div id=notification1 class=errorbox>This function not enabled in demo mode .</div>";
        exit;
    }
    dquery("DELETE FROM tbl_blogcats WHERE `id`='" . $id . "'");
    dquery("UPDATE tbl_blogcats SET `sort`=`sort`-1 WHERE `sort`>'" . $sort["sort"] . "'");
}
$sql = dquery("SELECT * FROM tbl_blogcats  ORDER  BY `sort`");
$loop = 1;
for ($total = mysqli_num_rows($sql); $row = mysqli_fetch_assoc($sql); $loop++) {
    echo "        <tr id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n            <td>";
    echo $row["name"];
    echo "</td>              \n            <td align=\"right\">\n                <a class=\"default_dg_a2 editdata\" href=\"javascript:load_subpage('main2.php?page=editblogcat&id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo " ";
    echo $LNG["category"];
    echo "')\">";
    echo $LNG["edit"];
    echo "</a> \n             <a class=\"default_dg_a2 deletedata\"   onclick=\"return confirm('Are you sure want to remove Category ?');\"  href=\"javascript:reloadcurrent('blogcategorylist','";
    echo $row["id"];
    echo "&delete=true')\">";
    echo $LNG["delete"];
    echo "</a>\n             </td>\n        </tr>\n";
}
echo "  \n   \n</tbody></table></form>\n</div>\n</div></div>\n";
if ($delete) {
    echo "</div>";
}
echo "\n<div class=\"page_info\" id=\"page_info\">\n<li>Just Drag and drop to change position of Category</li>\n</div>";
$fileverioncheck = "6.1.0";

?>