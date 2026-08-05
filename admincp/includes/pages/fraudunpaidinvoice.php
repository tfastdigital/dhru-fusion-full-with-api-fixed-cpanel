<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Process Unpaid Invoices</a></li>\n</ul>\n";
$pageid = 509;
checkPagePermission($pageid);
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
if ($mode == "process" && $rid) {
    global $adminAddPayment;
    $adminAddPayment = true;
    require ROOTDIR . "/includes/invoice.fun.php";
    $ibi = explode("-", $rid);
    foreach ($ibi as $invoiceid) {
        processInvoicetoPaid(trim($invoiceid));
    }
}
$sql = "SELECT id,date,(select `value` from tbl_paymentgateways \nwhere gateway=paymentmethod and setting='name') as gateway\n ,\n CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',userid,'\\',\\' ',(SELECT username FROM tblUsers WHERE tblUsers.id=userid),'\\')\">',(SELECT username FROM tblUsers WHERE tblUsers.id=userid),'</a>' )  AS user,\n CONCAT(total,' ',(SELECT (select code from tbl_currencies where id=default_currency)\n  FROM tblUsers WHERE id=userid)) AS tot,\n  \n  CONCAT('<a \n onclick=\"load_subpage(\\'main2.php?page=edituser.editinvoice&id=',tbl_invoices.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["invoice"] . " [#',IF(tbl_invoices.status='Unpaid',concat('P/',tbl_invoices.mask),concat('I/',tbl_invoices.mask) ),']\\');\">',IF(tbl_invoices.status='Unpaid',concat('P/',tbl_invoices.mask),concat('I/',tbl_invoices.mask) ),'</a>')\n as invoiceno, \n  \n  CONCAT('<a   class=\\'default_dg_a2 editdata\\'\n onclick=\"load_subpage(\\'main2.php?page=edituser.editinvoice&id=',tbl_invoices.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["invoice"] . " [#',IF(tbl_invoices.status='Unpaid',concat('P/',tbl_invoices.mask),concat('I/',tbl_invoices.mask) ),']\\');\">',IF(tbl_invoices.status='Unpaid',concat('P/',tbl_invoices.mask),concat('I/',tbl_invoices.mask) ),'</a>')\n as action\n\nFROM `tbl_invoices` WHERE status='Unpaid'\n and total=(select sum(amountin) from\ntbl_transaction where invoiceid=tbl_invoices.id) ";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "process" => ["view" => true, "flag_name" => "process", "flag_value" => "yes", "tooltip" => "Process Transaction"]];
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
$filtering_fields = ["Invoice ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_invoices", "field" => "id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Invoice From" => ["type" => "dropdownlist", "table" => "tbl_invoices", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $unpaidfrom, "condition" => "", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["invoiceno" => ["header" => "#" . $LNG["invoice"] . " " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "id" => ["header" => "#" . $LNG["reference"] . " " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gateway" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "tot" => ["header" => (string) $LNG["total"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_invoices";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>