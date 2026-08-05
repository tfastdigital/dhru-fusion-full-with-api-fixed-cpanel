<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Sales Report</a></li>\n</ul>\n<style>\nth.dg_right {\n    font-size: 16px !important;   \n    font-weight:bold !important; \n    text-indent: 0px;\n}\n</style>\n";
if (!$wid) {
    $w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
    $wid = $w["mywarehouse"];
}
if (!$wid) {
    echo "        <div id=\"notification1\" class=\"info\">\n        No default warehouse selected fro this admin\n        </div>\n        ";
}
echo "<select name=\"warehouse\" \nonchange=\"javascript: location.href='main2.php?page=pos.report.sales&wid='+this.value\">\n";
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
echo "</select>\n<br />\n";
$pageid = 488;
checkPagePermission($pageid);
licince\reqaddon("POS");
include DATAGRID_DIR . "comm.php";
$sql = "SELECT tbl_invoices.id,date,subtotal,total,notes,(tax+tax2) as totaltax,\n(select count(id) from tbl_invoiceitems where invoiceid=tbl_invoices.id) as cnt,\n(SELECT paymentmethod FROM tbl_invoiceitems WHERE invoiceid=tbl_invoices.id limit 1)\nas payment,\nround(\n(tbl_invoices.total-(SELECT sum(purchase_cost) from tbl_order_product\nwhere tbl_order_product.order_id IN \n(select relid from tbl_invoiceitems where invoiceid=tbl_invoices.id))),2)\n\n\n as profit,\n(select tbl_admin.username from tbl_admin where tbl_admin.id=tbl_invoices.adminid) as soldby,\n(select tblUsers.username from tblUsers where tblUsers.id=tbl_invoices.userid) as soldto\nFROM tbl_invoices\n WHERE  tbl_invoices.status='Paid' and pos='1'\n  and tbl_invoices.warehouse='" . $wid . "'";
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
$one = date("Y-m-d", strtotime("-1 month"));
$year = date("Y") . "-01-01";
$tone = date("Y-m") . "-01";
$unpaidfrom[date("Y-m-d")] = "Today";
$unpaidfrom[$yesterday] = "Yesterday";
$unpaidfrom[$week] = "Last 7 days";
$unpaidfrom[$one] = "Last 30 Days";
$unpaidfrom[$tone] = "This Month";
$unpaidfrom[$year] = "This Year";
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
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["Order From" => ["type" => "dropdownlist", "table" => "tbl_invoices", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $unpaidfrom, "condition" => "", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => "#" . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "cnt" => ["header" => (string) $LNG["items"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "soldby" => ["header" => $LNG["sold"] . " " . $LNG["_by"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "subtotal" => ["header" => (string) $LNG["subtotal"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "total" => ["header" => (string) $LNG["total"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "totaltax" => ["header" => (string) $LNG["tax"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "profit" => ["header" => (string) $LNG["profit"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "payment" => ["header" => $LNG["payment"] . " " . $LNG["type"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "note" => ["header" => (string) $LNG["note"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
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