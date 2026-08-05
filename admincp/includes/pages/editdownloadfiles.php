<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($update) {
    checkDemoMode(false);
    $data["filename"] = $filename;
    if ($_FILES["file"]["error"] <= 0) {
        $fext = substr($_FILES["file"]["name"], strrpos($_FILES["file"]["name"], "."));
        $finename = str_replace($fext, "", $_FILES["file"]["name"]);
        $filename = md5($finename . time()) . $fext;
        move_uploaded_file($_FILES["file"]["tmp_name"], ROOTDIR . "/" . $donloaddirpath . "/" . $filename);
        $data["file"] = $filename;
        $data["size"] = round($_FILES["file"]["size"] / 1024 / 1024, 2);
    }
    $data["external"] = $external;
    $data["description"] = $info;
    $data["group_id"] = $group_id;
    $data["reqlogin"] = $reqlogin;
    $data["forproduct"] = $forproduct;
    $data["donotshow"] = $donotshow;
    $data["date"] = $date;
    $db->update("tbl_download", $data, "id=" . $id);
    $data = NULL;
    echo "<div id='notification1' class='successbox'>Download File update successfully</div>";
}
echo "<div id=\"notification\"></div>\n<div id=\"content_padded\">\n\n<form id=\"frm\" name=\"\" enctype=\"multipart/form-data\" method=\"post\">\n<input type=\"hidden\" name=\"loaddefaultpage\" value=\"downloadfiles.php\" />\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
$dow = mysqli_fetch_assoc(dquery("select * from tbl_download where id='" . $id . "'"));
echo "    <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n    <tbody>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " *</td>\n        <td class=\"fieldarea\"><input name=\"file\"  value=\"\" type=\"file\"/></td>\n    </tr>\n      <tr>\n        <td></td><td>OR</td>\n    </tr>\n    <tr>\n        <td class=\"fieldlabel\">External ";
echo $LNG["link"];
echo " *</td>\n        <td class=\"fieldarea\">\n        <input name=\"external\"  size=\"50\" value=\"";
echo $dow["external"];
echo "\" type=\"text\"/></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["category"];
echo " </td>\n        <td class=\"fieldarea\">\n         <select name=\"group_id\">\n        ";
$cat = dquery("select id,category from tbl_downloadcat where mid=0");
while ($r = mysqli_fetch_assoc($cat)) {
    echo "        <option value=\"";
    echo $r["id"];
    echo "\"\n        ";
    if ($dow["group_id"] == $r["id"]) {
        echo "selected";
    }
    echo "        >";
    echo $r["category"];
    echo "</option>\n        ";
    $catg = dquery("select id,category from\n             tbl_downloadcat where mid=" . $r["id"]);
    while ($rg = mysqli_fetch_assoc($catg)) {
        echo "        <option ";
        if ($dow["group_id"] == $rg["id"]) {
            echo "selected";
        }
        echo "        value=\"";
        echo $rg["id"];
        echo "\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo $rg["category"];
        echo "</option>\n                ";
    }
}
echo "        </select>&nbsp; <a href=\"#\" data-target=\"downloadmain\" data-target-header=\"";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["add"];
echo " ";
echo $LNG["new"];
echo " ";
echo $LNG["category"];
echo "</a>\n        </td>\n    </tr>\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["file"];
echo " ";
echo $LNG["name"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"text\" name=\"filename\" value=\"";
echo $dow["filename"];
echo "\" /></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["description"];
echo " </td>\n        <td class=\"fieldarea\"><textarea name=\"info\" >";
echo $dow["description"];
echo "</textarea></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["required"];
echo " ";
echo $LNG["login"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\"\n        ";
if ($dow["reqlogin"]) {
    echo "checked='checked'";
}
echo " name=\"reqlogin\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"sa\" value=\"1\" /> <label for=\"sa\" ></label></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["for"];
echo " ";
echo $LNG["productsservices"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\" name=\"forproduct\"\n        ";
if ($dow["forproduct"]) {
    echo "checked='checked'";
}
echo " id=\"fa\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" value=\"1\" /><label for=\"fa\"></label></td>\n    </tr>\n\n    <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["donotshowclient"];
echo "</td>\n        <td class=\"fieldarea\"><input type=\"checkbox\"\n        ";
if ($dow["donotshow"]) {
    echo "checked='checked'";
}
echo " name=\"donotshow\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"lo\" value=\"1\" /><label for=\"lo\"></label></td>\n    </tr>\n     <tr>\n        <td class=\"fieldlabel\">";
echo $LNG["available"];
echo " ";
echo $LNG["till"];
echo " ";
echo $LNG["date"];
echo "</td>\n        <td class=\"fieldarea\">\n        <input name=\"date\" id=\"date\" class=\"datepicker\"  autocomplete=\"off\"  size=\"10\" value=\"";
echo $dow["date"];
echo "\" type=\"text\"/>\n        <small>Leave blank for keep live</small>\n        </td>\n    </tr>\n    <tr>\n        <td></td>\n        <td class=\"fieldarea\"><input value=\"";
echo $LNG["update"];
echo "\" name=\"update\" id=\"btnaddgroup\"  class=\"btn save\" type=\"submit\"/> </td>\n    </tr>\n    </tbody>\n    </table>\n<br />\n";
if (!$dow["forproduct"]) {
    echo "<textarea cols=\"100\">\n";
    if ($dow["external"]) {
        echo $dow["external"];
    } else {
        echo $config["site_address"];
        echo "download.php?action=downloads&type=file&id=";
        echo md5($dow["id"]);
    }
    echo "</textarea>\n";
}
echo "</form>\n";
include DATAGRID_DIR . "comm.php";
$sql = "SELECT\nid,ip,username,time,(select filename from tbl_download where id=did) as file\nFROM tbl_download_log WHERE did='" . $id . "'";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "id";
$default_order_type = "ASC";
$dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);
$ajax_option = true;
$dgrid->AllowAjax($ajax_option);
$layouts = ["edit" => "0", "details" => "0", "filter" => "1"];
$dgrid->SetLayouts($layouts);
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => true]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory);
$exporting_types = ["excel" => "true", "pdf" => "true", "xml" => "true"];
$dgrid->AllowExportingTypes($exporting_types);
$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dropdown_paging = true;
$dgrid->AllowPaging($paging_option, $rows_numeration, $numeration_sign, $dropdown_paging);
$bottom_paging = ["results" => true, "results_align" => "left", "pages" => true, "pages_align" => "center", "page_size" => true, "page_size_align" => "right"];
$top_paging = [];
$pages_array = ["5" => "5", "10" => "10", "25" => "25", "50" => "50", "100" => "100", "250" => "250", "500" => "500", "1000" => "1000"];
$default_page_size = 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = false;
$show_search_type = false;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["time" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "file" => ["header" => "File", "type" => "textarea", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ip" => ["header" => "IP", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "username" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_download_log";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "</div>";
$fileverioncheck = "6.1.0";

?>