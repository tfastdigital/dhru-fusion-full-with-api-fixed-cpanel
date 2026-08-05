<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($sort && $type) {
    include "imeiservice.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 34;
checkPagePermission($pageid);
$admin_template = $config["admin_template"];
global $admin_template;
if ($allowtelegram) {
    dquery("update tbl_imei_group set disabletelegram='0' where id in (" . implode(",", $ids) . ")");
}
if ($removetelegram) {
    dquery("update tbl_imei_group set disabletelegram='1' where  id in (" . implode(",", $ids) . ")");
}
if ($deleteimeigroup) {
    foreach ($ids as $val) {
        dquery("update tbl_services_imei set active=0 where group_id='" . $val . "'");
        dquery("update tbl_service_status set status=0 where serviceid in (select\nid from tbl_services_imei where group_id='" . $val . "')");
        if (dquery("delete from tbl_imei_group where id=" . $val)) {
            $success = (string) $LNG["successfullydeleted"];
        }
    }
}
if ($type && $sort != "") {
    sortOrder("tbl_imei_group", "display_order", "id", $sort, $type);
}
if ($error) {
    echo "<div id=notification1 class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification1 class=successbox>" . $success . "</div>";
}
if ($server) {
    $wherecond = " where `server`=" . $server;
} else {
    $wherecond = " where `server`=0";
}
$img_green = "";
$sql = dquery("SELECT tbl_imei_group.id,CONCAT( '<a class=\\'default_dg_a\\' \nhref=\"javascript:load_subpage(\\'main2.php?page=editimeigroup&id=',tbl_imei_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">',group_name,'</a>' )  AS groupname, \nactive,IF(disabletelegram,'','" . $img_green . "') as telegram,\n\nif( active = '1', '" . $img_green . "','" . $img_red . "')  AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' \n\nhref=\"javascript:load_subpage(\\'main2.php?page=editimeigroup&id=',tbl_imei_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_imei_group " . $wherecond . " ORDER BY display_order ASC");
echo "\n\n<div id=\"notification1\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form method='post' >\n<input type='hidden' name='defaultpage' value='imeiservice.tviewgroup.php' />\n<table id=\"main_tbl\" style=\"display: ";
echo $display;
echo ";\" class=\"quicksort\">\n<thead>\n   <tr class='nodrag tsTitles'>\n      <th width=\"20px\" class=\"sorter-false\"> <input value=\"ALL\" class=\"check-all\" name=\"all_imei\" onClick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /></th>\n      <th>";
echo $LNG["groupname"];
echo "</th>\n      <th class=\"sorter-false\">";
echo $LNG["status"];
echo "</th>\n      <th class=\"sorter-false\">";
echo $LNG["active"];
echo " ";
echo $LNG["service"];
echo "</th>\n      <th class=\"sorter-false\">";
echo $LNG["inactive"];
echo " ";
echo $LNG["service"];
echo "</th>\n      <th class=\"sorter-false\">Telegram</th>\n      <th class=\"sorter-false\"><div align=\"right\">";
echo $LNG["action"];
echo "</div></th>\n   </tr>\n</thead>\n<tbody class=\"tsGroup\">\n";
$e = 0;
while ($row = mysqli_fetch_assoc($sql)) {
    $e++;
    echo "\t<tr id=\"";
    echo $row["id"];
    echo "\" title=\"Drag & Drop to Change Position\">\n\t<td><input type='checkbox' name='ids[";
    echo $row["id"];
    echo "]' value='";
    echo $row["id"];
    echo "' /></td>\n\t<td class=\"w-100\">";
    echo html_entity_decode($row["groupname"]);
    echo "</td>\n        <td class=\"text-center\">";
    echo $row["active"] ? "<div class='green-square'></div>" : "<div class='red-square'></div>";
    echo "</td>\n    <td class=\"text-center\">";
    echo mysqli_num_rows(dquery("select id from tbl_services_imei\n    where group_id='" . $row["id"] . "' and active=1"));
    echo "</td>\n    <td  class=\"text-center\">";
    echo mysqli_num_rows(dquery("select id from tbl_services_imei\n    where group_id='" . $row["id"] . "' and active=0"));
    echo "</td>\n\t</td>\n        <td class=\"text-center\">";
    echo $row["telegram"];
    echo "</td>\n\t<td align=\"right\">";
    echo $row["action_links"];
    echo "</td>\n\t</tr>\n";
}
echo "\n\n\n\n</tbody></table>\n\n\n    <script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n    <script>\n        \$('#main_tbl').tableDnD({\n            onDrop: function(table, row) {\n                var serialized= \$.tableDnD.serialize();\n                \$.ajax({\n                    type: 'POST',\n                    url: \"includes/pages/imeigroup.order.save.php\",\n                    data: serialized,\n                    success: function(data) {\n                        \$(\"#notification1\").addClass('successbox');\n                        \$(\"#notification1\").html(data).show();\n                    }\n                });\n            }\n        });\n    </script>\n<p align=\"left\"><img src=\"templates/";
echo $_SESSION["admin_template"];
echo "/images/arrow_ltr.png\"/> <i> selected item</i> &nbsp;&nbsp;&nbsp;\n    <input type='submit' onclick=\"return confirm('Are you sure want to remove ?');\" name='deleteimeigroup' class=\"button_remove\" value='Delete'/>\n    <input type=\"submit\" name=\"allowtelegram\" value=\"Allow Telegram\" class=\"button_save\" />\n    <input type=\"submit\" name=\"removetelegram\" value=\"Remove Telegram\" class=\"button_save\" />\n</p>\n\n</form>\n</div>\n</div>\n";
if ($sort && $type) {
    echo "</div> ";
}
echo "\n\n\n<div id=\"page_info\" class=\"page_info\">\n<li>Listing IMEI service groups</li>\n<li>Just Drag and drop to change postion of listing</li>\n</div>";
$fileverioncheck = "6.1.0";
echo "\n<!--\n<div class=\"add-new\">\n    <a onclick=\"AddnewInpopup(this);\" data-target-header=\"Add IMEI Group\" data-target=\"addimeigroup\" href=\"#\">+</a>\n</div>\n-->\n";

?>