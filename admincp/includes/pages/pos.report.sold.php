<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Sold Item Report</a></li>\n</ul>\n<style>\nth.dg_right {\n    font-size: 16px !important;   \n    font-weight:bold !important;\n    text-indent:0px; \n}\n</style>\n";
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin \n    where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
echo "<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=pos.report.sold&wid='+this.value\">\n";
$s = dquery("select id,name from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo "<option ";
    if ($wid != "" && $wid == $r["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["name"];
    echo "</option>\n";
}
echo "</select>\n<br />";
$pageid = 489;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR . "comm.php";
$sql = "SELECT distinct tbl_products.id,service_name,(select count(invoiceid) from tbl_invoiceitems\n where \n relid IN (SELECT order_id from tbl_order_product where service_id=tbl_products.id and user_can_c=4) and pos=1  and warehouse='" . $wid . "') as sold  ,\n (select sum(purchase_cost) from tbl_order_product where \n service_id=tbl_products.id  and pos=1 and warehouse='" . $wid . "') as purchase,\n (select CONCAT(sum(credit)-sum(discount)) from tbl_order_product where \n service_id=tbl_products.id  and pos=1 and warehouse='" . $wid . "') as soldcost,\nCONCAT( (select CONCAT(sum(credit)-sum(discount)) from tbl_order_product where \n service_id=tbl_products.id  and pos=1 and warehouse='" . $wid . "')-(select sum(purchase_cost) from tbl_order_product where \n service_id=tbl_products.id  and pos=1 and warehouse='" . $wid . "') ) as profit,\n (SELECT CONCAT(sum(tax)+sum(tax2)) as totaltax from \n tbl_invoices where id in ( select invoiceid from tbl_invoiceitems where relid  \n IN ( select order_id from tbl_order_product where service_id=tbl_products.id))\n   and pos=1 and tbl_invoices.warehouse='" . $wid . "') as totx\n   ,\n  ( (select sum(stockin) as stin \n    from tbl_warehousestock where pid=tbl_products.id and wid='" . $wid . "')-\n    (select sum(stockout) as stout \n    from tbl_warehousestock where pid=tbl_products.id and wid='" . $wid . "')\n    ) as stock\nFROM `tbl_products` \nwhere 1=1";
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
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_products`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$sql = dquery("SELECT `id`,`group_name` FROM `tbl_product_group`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $group[$rows["id"]] = $rows["group_name"];
}
$yesterday = date("Y-m-d", strtotime("-1 day"));
$week = date("Y-m-d", strtotime("-7 day"));
$one = date("Y-m-d", strtotime("-2 month"));
$six = date("Y-m-d", strtotime("-7 month"));
$year = date("Y-m-d", strtotime("-12 month"));
$unpaidfrom[$yesterday] = "Yesterday";
$unpaidfrom[$week] = "Last one week";
$unpaidfrom[$one] = "Last one month";
$unpaidfrom[$six] = "Last six month";
$unpaidfrom[$year] = "Last one year";
$month[1] = "Jan";
$month[2] = "Feb";
$month[3] = "March";
$month[4] = "Apr";
$month[5] = "May";
$month[6] = "Jun";
$month[7] = "Jul";
$month[8] = "Aug";
$month[9] = "Sep";
$month[10] = "Oct";
$month[11] = "Nov";
$month[12] = "Dec";
$fill_from_retail_shop = ["1" => "Yes"];
$filtering_fields = ["Service" => ["type" => "dropdownlist", "table" => "tbl_products", "field" => "id", "field_view" => "service_name", "filter_condition" => "", "order" => "ASC", "source" => $service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Group" => ["type" => "dropdownlist", "table" => "tbl_products", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "service_name" => ["header" => (string) $LNG["product"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "stock" => ["header" => (string) $LNG["stock"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "20", "case" => "normal", "summarize" => "true"], "sold" => ["header" => $LNG["total"] . " " . $LNG["sold"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "20", "case" => "normal", "summarize" => "true"], "purchase" => ["header" => $LNG["purchase"] . " " . $LNG["cost"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "20", "case" => "normal", "summarize" => "true"], "soldcost" => ["header" => $LNG["sold"] . " " . $LNG["cost"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => "true"], "totx" => ["header" => $LNG["total"] . " " . $LNG["tax"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => "true"], "profit" => ["header" => (string) $LNG["profit"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => "true"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_products";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>