<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($p) {
    include "monthlyorder.head.php";
    echo "\t<div id=\"tabcontent\">\n\t";
}
$pageid = 454;
checkPagePermission($pageid);
if ($_ff_onSUBMIT_FILTER == "Search") {
    include "monthlyorder.head.php";
    echo "<div id='tabcontent'>";
}
include DATAGRID_DIR . "comm.php";
$YEAR = date("Y");
$MONTH = date("m");
if (isset($_GET["_ff_onSUBMIT_FILTER"]) && isset($_GET["_ff_tbl_order_imei_date"])) {
    $sql = "SELECT tbl_order_product.order_id, \ndate,\n\n(SELECT `service_name` FROM tbl_products WHERE tbl_products.id=tbl_order_product.service_id) AS service,\nCONCAT('<a href=\"mailto:',tblUsers.email,'\">',(SELECT `username` FROM tblUsers WHERE tblUsers.id=tbl_order_product.user_id),' (',tbl_order_product.user_id,')</a>') AS user,\nCONCAT((tbl_order_product.credit-tbl_order_product.discount),' ',(select code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=user_id))) as credit,\nCONCAT(IF(tbl_order_product.user_can_c='1','Pending',IF(tbl_order_product.user_can_c='3','Rejected',IF(tbl_order_product.user_can_c='4','Available','New')))) AS status\nFROM tbl_order_product\nLEFT OUTER JOIN tblUsers ON\n`tbl_order_product`.user_id = tblUsers.id \n WHERE 1=1 ";
} else {
    $sql = "SELECT tbl_order_product.order_id, \ndate,\n(SELECT `service_name` FROM tbl_products WHERE tbl_products.id=tbl_order_product.service_id) AS service,\nCONCAT('<a href=\"mailto:',tblUsers.email,'\">',(SELECT `username` FROM tblUsers WHERE tblUsers.id=tbl_order_product.user_id),' (',tbl_order_product.user_id,')</a>') AS user,\nCONCAT((tbl_order_product.credit-tbl_order_product.discount),' ',(select code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=user_id))) as credit,\nCONCAT(IF(tbl_order_product.user_can_c='1','Pending',IF(tbl_order_product.user_can_c='3','Rejected',IF(tbl_order_product.user_can_c='4','Available','New')))) AS status\nFROM tbl_order_product\nLEFT OUTER JOIN tblUsers ON\n`tbl_order_product`.user_id = tblUsers.id \n WHERE tbl_order_product.date BETWEEN '" . $YEAR . "-" . $MONTH . "-01' AND '" . $YEAR . "-" . $MONTH . "-31'\n";
}
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "order_id";
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
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["1" => "Enable", "0" => "Disable"];
$result = dquery("select id,service_name from tbl_products ");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_group[$row["id"]] = $row["service_name"];
}
$stat = ["New", "Pending", "3" => "Rejected", "4" => "Available"];
$mon = [$YEAR . "-01-01' AND '" . $YEAR . "-01-31" => "January", $YEAR . "-02-01' AND '" . $YEAR . "-02-31" => "Febuary", $YEAR . "-03-01' AND '" . $YEAR . "-03-31" => "March", $YEAR . "-04-01' AND '" . $YEAR . "-04-31" => "April", $YEAR . "-05-01' AND '" . $YEAR . "-05-31" => "May", $YEAR . "-06-01' AND '" . $YEAR . "-06-31" => "June", $YEAR . "-07-01' AND '" . $YEAR . "-07-31" => "July", $YEAR . "-08-01' AND '" . $YEAR . "-08-31" => "Auguest", $YEAR . "-09-01' AND '" . $YEAR . "-09-31" => "Sepember", $YEAR . "-10-01' AND '" . $YEAR . "-10-31" => "October", $YEAR . "-11-01' AND '" . $YEAR . "-11-31" => "November", $YEAR . "-12-01' AND '" . $YEAR . "-12-31" => "December"];
$filtering_fields = ["Month" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $mon, "condition" => "", "show_operator" => "false", "default_operator" => " BETWEEN ", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "service_id", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "user_can_c", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $stat, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["orderid"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["product"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "credit" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_product";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($p) {
    echo "</div>";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>