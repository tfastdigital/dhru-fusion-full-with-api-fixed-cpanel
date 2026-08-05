<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Pending Orders</a></li>\n</ul>\n";
$pageid = 482;
checkPagePermission($pageid);
global $adminAddPayment;
$adminAddPayment = true;
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
$sql = "SELECT order_id,date,gateway,\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\" >',ip,'</a>') AS ip,\n (select service_name from tbl_services_imei where id=service_id) \n as service,imei,(credit-discount) as amount,\nCONCAT('<a href=\"javascript: load_subpage(\\'main2.php?page=utilities.processorder&id=',order_id,'\\',\\'Pending Order\\')\">Process Order</a>') as action\nFROM `tbl_order_imei` WHERE user_can_c='6'";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "order_id";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => true], "details" => ["view" => false], "Delete Selected" => ["view" => false, "flag_name" => "deleteorder", "flag_value" => "yes", "tooltip" => "Delete Selected"]];
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
$pages_array = ["5" => "5", "10" => "10", "25" => "25", "50" => "50", "100" => "100", "250" => "250", "500" => "500", "1000" => "1000", "5000" => "5000"];
$default_page_size = 50;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$yesterday = date("Y-m-d", strtotime("-1 day"));
$week = date("Y-m-d", strtotime("-10 day"));
$one = date("Y-m-d", strtotime("-1 month"));
$unpaidfrom[date("Y-m-d")] = "Today";
$unpaidfrom[$week] = "Last 10 days";
$unpaidfrom[$one] = "Last 30 Days";
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "order_id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Order From" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $unpaidfrom, "condition" => "", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "IP" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "ip", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "imei" => ["header" => "IMEI", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "gateway" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_imei";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>