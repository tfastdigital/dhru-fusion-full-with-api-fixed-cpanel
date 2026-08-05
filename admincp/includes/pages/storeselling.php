<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"javascript:void(0)\">Store Product Selling</a></li>\n</ul>\n";
include_once DATAGRID_DIR . "comm.php";
$pageid = 520;
checkPagePermission($pageid);
$sql = "SELECT \norder_id,date,\nCONCAT((credit-discount),' ',(select code from tbl_currencies where id=(select default_currency\nfrom tblUsers where id=tbl_order_product.reseller_id)))AS crdt,\npurchase_cost,invoiceid,\nprofit,\n(SELECT service_name FROM tbl_products WHERE id=service_id) as item,\nCONCAT((tbl_order_product.reseller_discount),' ',(select code from tbl_currencies\n where id=(select default_currency\nfrom tblUsers where id=tbl_order_product.reseller_id))) as reseller_discount,\nCONCAT('<a href=\"javascript:load_fromsubpage(\\'edituser&id=',user_id,'\\',\\' ',(select username from tblUsers where id=tbl_order_product.user_id),'\\')\">',(select username from tblUsers where id=tbl_order_product.user_id),'</a>') as user,\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\" >',ip,'</a>') AS ip,\nIF(user_can_c=0,'New',IF(user_can_c=1,'Accepted',IF(user_can_c=3,'Refunded','Shipped')))  as status\n,CONCAT('<a href=\"javascript:load_fromsubpage(\\'edituser&id=',reseller_id,'\\',\\' ',(SELECT username FROM tblUsers WHERE id=tbl_order_product.reseller_id),'\\')\">',(SELECT username FROM tblUsers WHERE id=tbl_order_product.reseller_id),'</a>') as reseller\nFROM tbl_order_product \nWHERE reseller_id!='0'";
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
$fill_from_status = ["New Order", "In Process", "3" => "Refunded", "4" => "Shipped"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`username` FROM `tblUsers`\n WHERE reseller_can_setupstore='1'");
while ($rows = mysqli_fetch_assoc($sql)) {
    $fill_from_sup[$rows["id"]] = $rows["username"];
}
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_product", "field" => "order_id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "user_can_c", "field_view" => "user_can_c", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Reseller" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "reseller_id", "field_view" => "reseller_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_sup, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["invoiceid" => ["header" => "#" . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "item" => ["header" => (string) $LNG["item"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "reseller" => ["header" => (string) $LNG["reseller"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "crdt" => ["header" => (string) $LNG["price"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "reseller_discount" => ["header" => (string) $LNG["commission"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
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
$fileverioncheck = "6.1.0";

?>