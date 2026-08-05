<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"javascript:void(0)\">User Statement</a></li>\n</ul> \n";
$pageid = 185;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
$sql = "SELECT\ntbl_statement_user.id,\nIF(type = 'DR',CONCAT('<span class=textred>',type,'</span>'),type) as type,  \n(SELECT username FROM tbl_admin WHERE id=tbl_statement_user.adminid) as admin,\n(SELECT username FROM tblUsers WHERE id=tbl_statement_user.uid) as user,\ntbl_statement_user.date,\ntbl_statement_user.description,\nCONCAT(tbl_statement_user.amount,' ',(select code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid))) as amount,\n\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\">',tbl_statement_user.ip,'</a>') as ip,\nstype\nFROM tbl_statement_user LEFT OUTER JOIN tblUsers ON\n`tbl_statement_user`.uid = tblUsers.id  WHERE sell_credit='0'\n";
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
$result = dquery("select username,id from tbl_admin");
while ($row = mysqli_fetch_assoc($result)) {
    $admin[$row["id"]] = $row["username"];
}
$result = dquery("select distinct SUBSTRING_INDEX(description,' ',2) as discription from tbl_statement_user");
while ($row1 = mysqli_fetch_assoc($result)) {
    $discription[$row1["discription"]] = $row1["discription"];
}
$fill_from_admin = $admin;
$fill_from_discription = $discription;
$fill_from_user_type = ["DR" => "Debit", "CR" => "Credit"];
$fill_from_service = ["imei" => "IMEI", "file" => "File", "server" => "Server", "product" => "Product"];
$filtering_fields = ["Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "Admin" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "adminid", "field_view" => "adminid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_admin, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Discription" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "description", "field_view" => "description", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_discription, "condition" => "", "show_operator" => "false", "default_operator" => "like", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Type" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "type", "field_view" => "type", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_user_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "stype", "field_view" => "stype", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "user" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "description" => ["header" => (string) $LNG["description"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "type" => ["header" => (string) $LNG["type"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "amount" => ["header" => (string) $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "stype" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "300", "case" => "normal"], "admin" => ["header" => $LNG["event"] . " " . $LNG["by"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "100", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_statement_user";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>