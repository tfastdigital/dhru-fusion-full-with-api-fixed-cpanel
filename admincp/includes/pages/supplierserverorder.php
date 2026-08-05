<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "<ul id=\"tabmenu\"> \n";
    if (!$OnlyEcommerce) {
        echo "<li><a onclick=\"getContect('#tab','main2.php?page=supplierimeiorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >IMEI ";
        echo $LNG["order"];
        echo "</a></li> \n<li><a onclick=\"getContect('#tab1','main2.php?page=supplierfileorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
        echo $LNG["file"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li> \n<li><a class='tabmenu_active'  onclick=\"getContect('#tab3','main2.php?page=supplierserverorder','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo "  ";
        echo $LNG["order"];
        echo "</a></li>\n";
    }
    echo "    \n<li><a onclick=\"getContect('#tab11','main2.php?page=suppliershoporder','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab11\" >";
    echo $LNG["product"];
    echo "  ";
    echo $LNG["order"];
    echo "</a></li>    \n<div style=\"clear: both;\"></div>\n</ul>\n<br />\n\n<div id=\"tabcontent\"> \n   ";
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT \norder_id,\ndate,\ntbl_order_server.credit,\ntbl_order_server.discount,\n(SELECT username FROM tbl_supplier WHERE id=reply_by_sup) as supplier, \nCONCAT((SELECT prefix from tbl_currencies where id=tblUsers.default_currency),' ',tbl_order_server.credit-tbl_order_server.discount) as total,   \n(SELECT `service_name` FROM `tbl_server_log` WHERE `id`=tbl_order_server.service_id) AS service,\nserver,\n(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_server.user_id) as username,\nCONCAT(IF(tbl_order_server.user_can_c=0,'New', IF(tbl_order_server.user_can_c=1,'Accepted',IF(tbl_order_server.user_can_c=4,'Replied','Rejected'))) ) as status\n\nFROM `tbl_order_server` \nLEFT OUTER JOIN tblUsers ON `tbl_order_server`.user_id = tblUsers.id \nLEFT OUTER JOIN tbl_server_log ON tbl_order_server.service_id=tbl_server_log.id\n WHERE reply_by_sup!='0'";
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
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_server_log`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_supplier`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $fill_from_sup[$rows["id"]] = $rows["username"];
}
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_server", "field" => "order_id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Supplier" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "reply_by_sup", "field_view" => "reply_by_sup", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_sup, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "service_id", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "user_can_c", "field_view" => "user_can_c", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_server", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_server", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "supplier" => ["header" => (string) $LNG["supplier"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "total" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_server";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div> \n   ";
}
$fileverioncheck = "6.1.0";

?>