<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 84;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR . "comm.php";
if ($_GET["_ff_onSUBMIT_FILTER"] != "Search") {
    if (!$year) {
        $year = date("Y");
    }
    $startForm = mktime(0, 0, 1, 1, 1, $year);
    $endto = mktime(0, 0, 0, 12, 31, $year);
    $where = "time>='" . $startForm . "' and time<='" . $endto . "' and ";
}
if ($type == "daily") {
    $conds = date("Y") . "-" . date("m");
} else {
    $conds = date("Y") . "-";
}
if ($stat == "answered") {
    $cond = "(user_can_c=3 or user_can_c=4)   AND reply_by_admin='" . $admin . "'";
} else {
    $cond = " user_can_c=1  AND acceptedby='" . $admin . "'";
}
$sql = "SELECT \norder_id,\ndate,\ncredit,\ndiscount, \ncredit-discount as total,ebay, \n(SELECT `service_name` FROM `tbl_services_imei` WHERE `id`=tbl_order_imei.service_id) AS service,\nimei,\n(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_imei.user_id) as username,\nCONCAT(IF(tbl_order_imei.user_can_c=0,'New', IF(tbl_order_imei.user_can_c=1,'Accepted',IF(tbl_order_imei.user_can_c=4,'Replied','Rejected'))) ) as status,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser.editimeiorder&id=',order_id,'\\',\\'IMEI Order ',order_id,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_order_imei` LEFT OUTER JOIN tblUsers ON\n`tbl_order_imei`.user_id = tblUsers.id WHERE  " . $cond . "\nand date like '" . $conds . "%'";
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
$dgrid->safeMode = false;
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage", "year"];
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
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_services_imei`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$fill_ebay = ["1" => "Yes", "0" => "No"];
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "order_id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "service_id", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "user_can_c", "field_view" => "userstatus", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Direct Order" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "ebay", "field_view" => "ebay", "filter_condition" => "", "order" => "ASC", "source" => $fill_ebay, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "IMEI" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "imei", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "imei" => ["header" => (string) $LNG["imei"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "action_links" => ["header" => (string) $LNG["edit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
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
if ($action == "refund" && $id) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>