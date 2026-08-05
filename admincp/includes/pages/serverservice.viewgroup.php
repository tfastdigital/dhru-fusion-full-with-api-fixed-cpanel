<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($sort && $type) {
    include "serverservice.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 34;
checkPagePermission($pageid);
$admin_template = $config["admin_template"];
global $admin_template;
if ($deleteservergroup) {
    foreach ($ids as $val) {
        dquery("update tbl_server_log set active=0 where group_id='" . $val . "'");
        if (dquery("delete from tbl_server_group where id=" . $val)) {
            $success = (string) $LNG["successfullydeleted"];
        }
    }
}
if ($type && $sort != "") {
    sortOrder("tbl_server_group", "display_order", "id", $sort, $type);
}
if ($error) {
    echo "<div id=notification1 class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification1 class=successbox>" . $success . "</div>";
}
$sql = dquery("SELECT tbl_server_group.id,CONCAT( '<a class=\\'default_dg_a\\' \nhref=\"javascript:load_subpage(\\'main2.php?page=editservergroup&id=',tbl_server_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">',group_name,'</a>' )  AS groupname, \nactive,\nCONCAT('<a href=\\'javascript:redirectedit(\\'imeiservice.viewgroup\\',',tbl_server_group.id,'\\'&sort=\\',tbl_server_group.display_order)\\'>UP</a>') as display,\nif( active = '1', '" . $img_green . "','" . $img_red . "')  AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' \n\nhref=\"javascript:load_subpage(\\'main2.php?page=editservergroup&id=',tbl_server_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_server_group ORDER BY display_order ASC");
echo "<div id=\"notification\"></div>\n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n\$('#main_tbl').tableDnD({\n    onDrop: function(table, row) {\n       var serialized= \$.tableDnD.serialize();\n        \$.ajax({\n\t\t\ttype: 'POST',\n\t\t\turl: \"includes/pages/servergroup.order.save.php\",\n\t\t\tdata: serialized,\n\t\t\tsuccess: function(data) {\n\t\t\t\t \$(\"#notification1\").addClass('successbox');\n\t\t\t     \$(\"#notification1\").html(data).show();\n\t\t\t}\n\t\t});\n    }\n});\n</script>\n<form method='post' >\n<input type='hidden' name='defaultpage' value='serverservice.viewgroup.php' />\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\" class=\"quick quicksort\">\n<thead>\n   <tr class=\"nodrag\">\n      <th width=\"20px\" class=\"sorter-false\"> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\" onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /></th>\n      <th class=\"w-100\">";
echo $LNG["groupname"];
echo "</th>\n      <th  class=\"sorter-false\">";
echo $LNG["status"];
echo "</th>\n      <th  class=\"sorter-false\"><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n   </tr>\n</thead>\n<tbody>\n";
$e = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $e++;
    echo "\t<tr id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n\t<td class=\"text-center\"><input type='checkbox' name='ids[";
    echo $row["id"];
    echo "]' value='";
    echo $row["id"];
    echo "' /></td>\n\t<td class=\"w-100\">";
    echo html_entity_decode($row["groupname"]);
    echo "</td>\n        <td class=\"text-center\">";
    echo $row["active"] ? "<div class='green-square'></div>" : "<div class='red-square'></div>";
    echo " \t</td>\n\t<td align=\"right\">";
    echo $row["action_links"];
    echo "</td>\n\t</tr>\n";
}
echo "\n\n\n\n</tbody></table>\n\n<p align=\"left\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/arrow_ltr.png\"/> <i> selected item</i> &nbsp;&nbsp;&nbsp; <input type='submit' onclick=\"return confirm('Are you sure want to remove group?');\" name='deleteservergroup' class=\"button_remove\" value='Delete'/></p>\n</form>\n</div>\n</div>\n";
if ($sort && $type) {
    echo "</div> ";
}
echo " <div id=\"page_info\" class=\"page_info\">\n<li>Listing Server Service groups</li>\n<li>Just Drag and drop to change postion of listing</li>\n</div>\n";
$fileverioncheck = "6.1.0";
echo "<!--\n<div class=\"add-new\">\n    <a onclick=\"AddnewInpopup(this);\" data-target-header=\"Add Server Group\" data-target=\"addservergroup\" href=\"#\">+</a>\n</div>\n-->\n";

?>