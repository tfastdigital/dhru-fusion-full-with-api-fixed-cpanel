<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
if ($_ff_onSUBMIT_FILTER) {
    echo "<ul id=\"tabmenu\"> \n<li><a\nonclick=\"getContect('#tab','main2.php?page=pos.addstock&s=ok','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\">";
    echo $LNG["add"];
    echo " ";
    echo $LNG["stock"];
    echo "</a></li> \n<li><a  class='tabmenu_active' \nonclick=\"getContect('#tab1','main2.php?page=pos.stockhistory','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\">";
    echo $LNG["stock"];
    echo " ";
    echo $LNG["history"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<br />\n<div id=\"tabcontent\">\n";
}
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
$sql = "select *,(select name from tbl_warehouse where tbl_warehouse.id=wid) \nas warehouse,(select username from tbl_supplier where id=sid) as \nsuppliers,IF(remove=1,CONCAT(status,' [Del]'),status) as status\n,IF(bill_no!='',bill_no,\nIF(relid!=0,\nCONCAT('<a class=\\'default_dg_a2 \\' href=\"javascript:load_fromsubpage(\\'edituser.editinvoice&id=',relid,'\\',\\'View Invoice\\')\">',relid,'</a>')\n,'')\n) as bills\n from tbl_stock_history where pid='" . $id . "'";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Active" => ["view" => false, "flag_name" => "Active", "flag_value" => "yes", "tooltip" => "Active"], "Inactive" => ["view" => false, "flag_name" => "Inactive", "flag_value" => "yes", "tooltip" => "Inactive"]];
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
$fill_from_status = ["Active", "Block", "New Registered"];
$fill_from_user_type = ["User", "Reseller", "3" => "Reseller's User"];
$result = dquery("select username,id from tbl_supplier");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_supplier[$row["id"]] = $row["username"];
}
$result = dquery("select name,id from tbl_warehouse");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_warehouse[$row["id"]] = $row["name"];
}
$fill_signup = ["" => "Normal signup", "quick" => "Quick Checkout", "direct" => "Direct Order"];
$filtering_fields = ["Supplier" => ["type" => "dropdownlist", "table" => "tbl_stock_history", "field" => "sid", "field_view" => "sid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_supplier, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Warehouse" => ["type" => "dropdownlist", "table" => "tbl_stock_history", "field" => "wid", "field_view" => "wid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_warehouse, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["qnt" => ["header" => (string) $LNG["qnt"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal", "width" => "10px"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "bill_date" => ["header" => "Bill Date", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "bills" => ["header" => "Bill/Invoice", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "warehouse" => ["header" => (string) $LNG["warehouse"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "suppliers" => ["header" => "Supplier", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_stock_history";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "\n";
if ($_ff_onSUBMIT_FILTER) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>