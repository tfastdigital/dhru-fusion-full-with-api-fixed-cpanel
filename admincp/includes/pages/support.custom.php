<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
$sql = "SELECT\nMIN(d.id) as id,\nCONCAT('<span style=\"background-color:',(select color from tbl_support_priority where id=d.pid),';\">&nbsp;&nbsp;&nbsp;&nbsp;</span>') as color,  \nd.date,\nd.message,\n(SELECT department from tbl_support_department where id=d.did) as department,\nCONCAT('<a class=\"default_dg_a2\" href=\"javascript:redirectedit(\\'support.open\\',\\'',MIN(d.id),'\\')\"><STRONG>[#',d.tid,'] ',(SELECT subject from tbl_support_tickets as f where f.id=MIN(d.id)),'</STRONG></a>') as subject,\nFROM_UNIXTIME(d.lastreply) as lastreply,\nIF(d.uid=0,d.name,CONCAT((select first_name from tblUsers where id=d.uid),' ',(select last_name from tblUsers where id=d.uid))) as user\nFROM tbl_support_tickets as d where d.sid='" . $id . "'\nGROUP BY d.tid\n";
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
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Delete Client" => ["view" => false, "flag_name" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete Client"]];
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
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["1" => "Closed", "3" => "Answered", "4" => "Customer-reply"];
$result = dquery("select department,id from tbl_support_department");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_depart[$row["id"]] = $row["department"];
}
$result = dquery("select priority,id from tbl_support_priority");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_priority[$row["id"]] = $row["priority"];
}
$filtering_fields = ["Submitter" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_support_tickets", "field" => "uid", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_support_tickets", "field" => "sid", "field_view" => "sid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Department" => ["type" => "dropdownlist", "table" => "tbl_support_tickets", "field" => "did", "field_view" => "did", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_depart, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Priority" => ["type" => "dropdownlist", "table" => "tbl_support_tickets", "field" => "pid", "field_view" => "pid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_priority, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_support_tickets", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_support_tickets", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["color" => ["header" => (string) $LNG["priority"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "department" => ["header" => (string) $LNG["department"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "subject" => ["header" => (string) $LNG["subject"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "lastreply" => ["header" => (string) $LNG["lastreply"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_support_tickets";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "\n\n";
$fileverioncheck = "6.1.0";

?>