<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 10;
if ($gid) {
    $id = $gid;
}
checkPagePermission($pageid);
require_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientsDetails = getSupplierDetails($id);
include_once ROOTDIR . "/includes/imeiservices.fun.php";
if ($clientsDetails["imei_service_access"]) {
    $enable = "checked";
    $display = "table";
} else {
    $enable = "";
    $display = "none";
}
if ($newserver) {
    $wherecond = " where `server`='" . $newserver . "'";
    $ServiceField = "server_logs";
    if ($newserver == 2) {
        $ServiceField = "remote_services";
    }
} else {
    $wherecond = " where `server`=0";
    $ServiceField = "imei_services";
}
$allowServices = explode(",", $clientsDetails[$ServiceField]);
if (isset($_GET["grpid"])) {
    $groups = $_GET["grpid"];
    include "editsupplier.head.php";
    echo "<div id=\"tabcontent\">";
} else {
    $sql = mysqli_fetch_assoc(dquery("select id from tbl_imei_group \n    " . $wherecond . " ORDER BY display_order"));
    $groups = $sql["id"];
}
$pagelimit = 10000;
$imeiServiceDetails = getIMEIServices($groups, "", "", true, true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $newserver ? $newserver : "0");
echo "<script>\nfunction enable_me(id)\n{\n    document.getElementById(id).style.display='table';\n}\nfunction disable_me(id)\n{\n    document.getElementById(id).style.display='none';\n}\n</script>\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
if ($newserver) {
    echo "    <input type=\"hidden\" value=\"";
    echo $newserver;
    echo "\" name=\"newserver\"/>\n";
}
echo generate_token("form");
echo "\n\n<table id=\"main_tbl\">\n            <thead>\n              <tr>\n                <th> <input value=\"ALL\" ";
if ($clientsDetails[$ServiceField] == "ALL") {
    echo "checked";
}
echo " class=\"check-all\" name=\"all_imei\" onclick=\"SetAllCheckBoxes(this)\" type=\"checkbox\" /><label></label>\n                  </th>\n                <th>\n\n<select  name=\"groups\"\nonchange=\"javascript: reloadcurrent('editsupplier.imei&grpid='+this.value+'&gid=";
echo $id;
echo "&laoddefaultpage=editsupplier.imei.php";
if ($newserver) {
    echo "&newserver=" . $newserver;
}
echo "');\">\n";
$sql = dquery("SELECT id,group_name FROM tbl_imei_group " . $wherecond . " ORDER BY display_order");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($_GET["grpid"] == $row["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $row["id"];
    echo "\">";
    echo $row["group_name"];
    echo "</option>\n";
}
echo "</select>\n\n                </th>\n                 <th align=\"left\">";
echo $LNG["purchase"];
echo " ";
echo $LNG["cost"];
echo "</th>\n\n              </tr>\n            </thead>\n            <tbody>\n<input type=\"hidden\" name=\"groupid\" value=\"";
echo $groups;
echo "\" />\n";
$imeiServiceDetailsKey = array_keys($imeiServiceDetails);
foreach ($imeiServiceDetailsKey as $group) {
    echo "<tr><td colspan=2><strong>" . $group . "</strong></td><td></td></tr>";
    foreach ($imeiServiceDetails[$group] as $keys) {
        if (in_array($keys["id"], $allowServices) || $clientsDetails[$ServiceField] == "ALL") {
            $selected = "checked=checked";
        } else {
            $selected = "";
        }
        echo "<tr>\n<td><input name=\"imei_check[";
        echo $keys["id"];
        echo "]\" ";
        echo $selected;
        echo " value=\"";
        echo $keys["id"];
        echo "\" type=\"checkbox\" /> <label></label></td><td>";
        echo $keys["service_name"];
        echo "</td>\n";
        if ($keys["credit"] - $keys["discount"] != $keys["credit"]) {
            $classChange = "chcreditvsmall-input";
        } else {
            $classChange = "vsmall-input";
        }
        echo "<td><input  style=\"text-align: right;width:100px\"  type=\"text\" class=\"vsmall-input\" name=\"pcost[";
        echo $keys["id"];
        echo "]\" value=\"";
        echo $keys["purchase_cost"];
        echo "\" /></td>\n</tr>\n";
    }
}
unset($keys);
echo "</tbody></table>\n\n\n<p   class=\"fixedbtn\">\n<input type=\"checkbox\" class=\"onoff {labelOn: 'Enable', labelOff: 'Disable'}\" name=\"access\" value=\"1\" ";
echo $enable;
echo " id=\"enable\"/><label for=\"enable\"></label>\n\n<input type=\"button\" class=\"btn btn-default floatright\" id=\"resetdiscount\" name=\"resetdiscount\" value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["discount"];
echo "\"\nonclick=\"javascript: resetDiscount();\"/>\n\n <input value=\"";
echo $LNG["save"];
echo "\"  style=\"margin-left: 10px;\" id=\"btnedituser\" class=\"btn\" type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editsupplier.imei','#frmedituser','#notification','true','#main_loader');\"/></p>\n\n</form></div></div>\n<div id=\"page_info\" class=\"page_info\">\n<li>Set service purchase cost. You can view transaction of payout by this cost and suppliers given credit.</li>\n</div>\t";
$fileverioncheck = "6.1.0";

?>