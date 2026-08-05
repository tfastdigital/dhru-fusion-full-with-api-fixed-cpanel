<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
if ($_ff_onSUBMIT_FILTER || $rid) {
    echo "<ul id=\"tabmenu\"> \n    <li><a  onclick=\"getContect('#tab','main2.php?page=downloadmain','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["download"];
    echo " ";
    echo $LNG["categories"];
    echo "</a></li> \n    <li><a   class=\"tabmenu_active\"   onclick=\"getContect('#tab12','main2.php?page=downloadfiles','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["download"];
    echo "s</a></li>\n    <li><a   onclick=\"getContect('#tab13','main2.php?page=addfile','','','#tabcontent',true,'#main_loader');\" id=\"tab13\" > ";
    echo $LNG["add"];
    echo " ";
    echo $LNG["files"];
    echo "</a></li>\n  <div style=\"clear: both;\"></div>\n</ul> <div id=\"tabcontent\">\n";
}
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR . "comm.php";
if ($id) {
    $where = " and group_id='" . $id . "'";
} else {
    $where = "";
}
$sql = "SELECT \nid,date,\nCONCAT('<a class=\\'default_dg_a2\\' href=\"includes/pages/dl.php?sampledownload=true&id=',tbl_download.id,'\">',filename,'</a>') as title,\ngroup_id,\n(select category from tbl_downloadcat where tbl_downloadcat.id=group_id) as groups,counter,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_subpage(\\'main2.php?page=editdownloadfiles&id=',tbl_download.id, '\\',\\'" . $LNG["edit"] . " " . $LNG["download"] . "\\' )\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_download` WHERE 1=1 " . $where;
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "id";
$default_order_type = "DESC";
$dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);
$ajax_option = true;
$dgrid->AllowAjax($ajax_option);
$layouts = ["edit" => "0", "details" => "0", "filter" => "1"];
$dgrid->SetLayouts($layouts);
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => true]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id"];
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
if ($config["adminlistlimit"] && !in_array($config["adminlistlimit"], $pages_array)) {
    $pages_array[$config["adminlistlimit"]] = $config["adminlistlimit"];
}
$default_page_size = $config["adminlistlimit"] ? $config["adminlistlimit"] : 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$result = dquery("select * from tbl_downloadcat");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_status[$row["id"]] = $row["category"];
}
$filtering_fields = ["File" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_download", "field" => "filename", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px"], "Category" => ["type" => "dropdownlist", "table" => "tbl_download", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["title" => ["header" => (string) $LNG["name"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "groups" => ["header" => (string) $LNG["category"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => $LNG["available"] . " " . $LNG["till"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "counter" => ["header" => (string) $LNG["counter"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_download";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>