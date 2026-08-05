<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 354;
checkPagePermission($pageid);
include_once DATAGRID_DIR . "comm.php";
if (isset($_GET["rid"])) {
    echo "<div id='tabcontent'>";
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_warehouse WHERE ID='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
if (isset($_GET["rid"]) || isset($_GET["_ff_onSUBMIT_FILTER"]) || $p) {
    echo "<ul id=\"tabmenu\"> \n<li><a  onclick=\"getContect('#tab','main2.php?page=manufacturelist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["manufacture"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li> \n<li><a class='tabmenu_active'  onclick=\"getContect('#tab12','main2.php?page=warehouselist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["warehouse"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n   <div id='tabcontent'> ";
}
echo " \n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div id=\"notification\"></div>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["warehouse"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"name\" /></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["address"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"address\" /></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["country"];
echo " </td>\n    <td class=\"fieldarea\">";
echo getCountriesDropDown();
echo "</td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["state"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"state\" /><br />\n    <small>";
echo $LNG["statenameincode"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["zip"] . "/" . $LNG["pin"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"zip\" /></td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn add\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','fieldwarehouse','#frm','#notification','true','#main_loader','main2.php?page=warehouselist');\"/> </td>\n</tr>\n\n</tbody>\n</table>\n\n</form>\n\n\n</div></div> \n\n<br />\n \n<table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                <th>";
echo $LNG["name"];
echo "</th>\n           \n                <th>";
echo $LNG["action"];
echo "</th>\n              </tr>\n            </thead>\n            <tbody>\n\n            \n";
if ($delete && $id) {
    dquery("DELETE FROM tbl_warehouse WHERE `id`='" . $id . "'");
}
$sql = dquery("SELECT * FROM tbl_warehouse ");
while ($row = mysqli_fetch_assoc($sql)) {
    $nums = mysqli_num_rows(dquery("select id from  `tbl_warehousestock` where wid='" . $row["id"] . "'"));
    echo "        <tr>\n            <td><a style=\"\" class=\"\" \n            href=\"javascript:load_subpage('main2.php?page=editwarehouse&id=";
    echo $row["id"];
    echo "','Edit Warehouse')\">\n            ";
    echo $row["name"];
    echo "            </a></td>\n          \n            <td>\n             ";
    if (!$nums) {
        echo "            <span title=\"delete\"><input type=\"button\" title=\"delete\" class=\"button deletedata\" \n            onclick=\"javascript: \n            if(confirm('Are you sure want to remove'))\n            {\n             redirectedit('warehouselist',";
        echo $row["id"];
        echo "+'&delete=true');\n            } \n             \" value=\"";
        echo $LNG["delete"];
        echo "\" /></span>\n             ";
    }
    echo "           <span title=\"edit\"><input class=\"button editdata\"\n            title=\"edit\" type=\"button\" \n            onclick=\"javascript:load_subpage('main2.php?page=editwarehouse&id=";
    echo $row["id"];
    echo "','Edit Warehouse')\" value=\"";
    echo $LNG["edit"];
    echo "\" /></span>             \n            </td>      \n        </tr>\n        ";
}
echo "\n</tbody></table>\n\n\n\n";
$fileverioncheck = "6.1.0";

?>