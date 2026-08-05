<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include DATAGRID_DIR . "comm.php";
$code = mysqli_fetch_assoc(dquery("select code from tbl_promotion where id='" . $id . "'"));
$code = dec($code["code"], "9486");
$sql = "SELECT \norder_id,\ndate,\ntbl_order_product.credit,\ntbl_order_product.discount, \ntbl_order_product.reply,\nIF(tbl_order_product.buyadvance=1,CONCAT(tbl_order_product.invoiceid,' ','[" . $LNG["preorder"] . "]'),tbl_order_product.invoiceid) as invoiceid,  \ntbl_order_product.credit-tbl_order_product.discount as total,   \nCONCAT((select subtotal from tbl_invoices where id=tbl_order_product.invoiceid),' ',(SELECT code FROM tbl_currencies where id=tblUsers.default_currency)) AS curtotal,\nCONCAT((SELECT `service_name` FROM `tbl_products` WHERE `id`=tbl_order_product.service_id),IF(gift=1,' [" . $LNG["gift"] . "]','')) AS service,\nimei,\n(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_product.user_id) as username,\nCONCAT(IF(tbl_order_product.user_can_c=0,'New', IF(tbl_order_product.user_can_c=1,'In Process',IF(tbl_order_product.user_can_c=4,'Sent',IF(tbl_order_product.user_can_c=6,'On Hold',IF(tbl_order_product.user_can_c=7,'Received','Rejected'))))) ) as status,\nCONCAT( '<a class=\\'default_dg_a editdata\\' href=\"javascript:redirectedit(\\'productorder.edit\\', \\'',tbl_order_product.invoiceid,'&action=edit&loaddefaultpage=productorder.history\\')\">" . $LNG["edit"] . "</a>' )  AS action  \nFROM `tbl_order_product` \nLEFT OUTER JOIN tblUsers ON `tbl_order_product`.user_id = tblUsers.id \nLEFT OUTER JOIN tbl_products ON tbl_order_product.service_id=tbl_products.id\n WHERE  \ninvoiceid IN ( select invoiceid from tbl_invoiceitems where promotion_code='" . $code . "' ) \n ";
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
$default_page_size = 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected", "4" => "Sent", "6" => "On Hold", "7" => "Received"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_products`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_admin`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $admins[$rows["id"]] = $rows["username"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_supplier`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $suppl[$rows["id"]] = $rows["username"];
}
$yesterday = date("Y-m-d", strtotime("-1 day"));
$week = date("Y-m-d", strtotime("-7 day"));
$one = date("Y-m-d", strtotime("-1 month"));
$year = date("Y") . "-01-01";
$tone = date("Y-m") . "-01";
$unpaidfrom[date("Y-m-d")] = "Today";
$unpaidfrom[$yesterday] = "Yesterday";
$unpaidfrom[$week] = "Last 7 days";
$unpaidfrom[$one] = "Last 30 Days";
$unpaidfrom[$tone] = "This Month";
$unpaidfrom[$year] = "This Year";
$sql = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
while ($rows = mysqli_fetch_assoc($sql)) {
    $apis[$rows["gateway"]] = $rows["value"];
}
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_product", "field" => "invoiceid", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "user_can_c", "field_view" => "user_can_c", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Order From" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $unpaidfrom, "condition" => "", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "By Admin" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "reply_by_admin", "field_view" => "reply_by_admin", "filter_condition" => "", "order" => "ASC", "source" => $admins, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "By Supplier" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "reply_by_sup", "field_view" => "reply_by_sup", "filter_condition" => "", "order" => "ASC", "source" => $suppl, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["invoiceid" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "curtotal" => ["header" => (string) $LNG["price"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "10", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
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