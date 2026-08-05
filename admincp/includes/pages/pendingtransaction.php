<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 424;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
$sql = "SELECT\ntbl_gatewaylog.id,\ntbl_gatewaylog.date,\n\nif((select `value` from tbl_paymentgateways\n where tbl_paymentgateways.gateway=tbl_gatewaylog.gateway \n and setting='name')!='',(select `value` from tbl_paymentgateways\n where tbl_paymentgateways.gateway=tbl_gatewaylog.gateway \n and setting='name'),gateway) as gateway,\n \nCONCAT('<textarea rows=\"3\" cols=\"50\" readonly=\"readonly\">',data,'</textarea>') as data,\ntbl_gatewaylog.`result` as results\nFROM tbl_gatewaylog where result='Received' and refid!='')";
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
$result = dquery("select \ngateway,\n(select value from tbl_paymentgateways\n where tbl_paymentgateways.gateway=tbl_gatewaylog.gateway and setting='name') as gateways \n\nfrom tbl_gatewaylog group by gateway");
while ($row = mysqli_fetch_assoc($result)) {
    $gate[$row["gateway"]] = $row["gateways"] ? $row["gateways"] : $row["gateway"];
}
$Status["Successful"] = "Successful";
$Status["Verified"] = "Verified";
$Status["Not Supported"] = "Not Supported";
$Status["Error"] = "Error";
$Status["Refunded"] = "Refunded";
$fill_from_admin = $admin;
$fill_from_discription = $discription;
$filtering_fields = ["ID" => ["type" => "textbox", "table" => "tbl_gatewaylog", "field" => "id", "field_view" => "id", "filter_condition" => "", "order" => "ASC", "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Data/Transaction ID " => ["type" => "textbox", "table" => "tbl_gatewaylog", "field" => "data", "field_view" => "data", "filter_condition" => "", "order" => "ASC", "condition" => "", "show_operator" => "false", "default_operator" => "%like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Client" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_gatewaylog", "field" => "result", "field_view" => "result", "filter_condition" => "", "order" => "ASC", "source" => $Status, "condition" => "", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Gateway" => ["type" => "dropdownlist", "table" => "tbl_gatewaylog", "field" => "gateway", "field_view" => "gateway", "filter_condition" => "", "order" => "ASC", "source" => $gate, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_gatewaylog", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_gatewaylog", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gateway" => ["header" => $LNG["payment"] . " " . $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "data" => ["header" => (string) $LNG["data"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "results" => ["header" => (string) $LNG["result"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_gatewaylog";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>