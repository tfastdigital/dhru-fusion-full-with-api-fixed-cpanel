<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 484;
checkPagePermission($pageid);
if ($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
if ($cancelinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("update tbl_affiliate_history set status='Cancel' where id=" . $val);
    }
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
echo "\n\n";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT\ntbl_affiliate_history.id,\nCONCAT('<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'edituser\\', ', tbl_affiliate_history.uid, ')\">',\n(SELECT CONCAT(username,' [',email,']') as tsed from tblUsers where id=uid)\n,'</a>') as user,\nIF(type='imei',\nCONCAT('<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'edituser.editimeiorder\\',',tbl_affiliate_history.oid,')\">',tbl_affiliate_history.oid,'</a>')\n,IF(type='server',CONCAT('<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'edituser.editserverorder\\',',tbl_affiliate_history.oid,')\">',tbl_affiliate_history.oid,'</a>'),\nCONCAT('<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'edituser.editproductorder\\',',tbl_affiliate_history.oid,')\">',tbl_affiliate_history.oid,'</a>'))\n\n) as oids,\noid,amount,comission,type,\n(select code from tbl_currencies where \ntbl_currencies.id=(select default_currency \nfrom tblUsers where tblUsers.id=tbl_affiliate_history.uid)) as code\nFROM tbl_affiliate_history\n WHERE tbl_affiliate_history.aid=" . $id;
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Cancel selected" => ["view" => false, "flag_name" => "cancelinvoice", "flag_value" => "yes", "tooltip" => "Cancel selected"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "by"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory);
$exporting_types = ["excel" => "false", "pdf" => "false", "xml" => "false"];
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
$fill_from_subscribe = ["imei" => "IMEI", "server" => "Server", "product" => "Product"];
$filtering_fields = ["Service  Type" => ["type" => "dropdownlist", "table" => "tbl_affiliate_history", "field" => "type", "field_view" => "subscribe", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_subscribe, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_affiliate_history", "field" => "oid", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_affiliate_history", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_affiliate_history", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$code = $clientDetails["currency"]["code"];
$vm_colimns = ["oids" => ["header" => (string) $LNG["orderid"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "amount" => ["header" => $LNG["amount"] . " [" . $code . "]", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "comission" => ["header" => $LNG["commission"] . " [" . $code . "]", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "type" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_affiliate_history";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) {
    echo "</div> ";
}
echo "\n";
$fileverioncheck = "6.1.0";

?>