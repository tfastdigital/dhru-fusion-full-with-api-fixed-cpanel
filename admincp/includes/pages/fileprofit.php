<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .default_dg_table thead tr th:last-child, #main_tbl thead tr th:last-child{\n        width:auto !important\n    }\n    .dg_right{\n        text-align: left !important;\n    }\n</style>\n";
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    include "profit.head.php";
    echo "<div id=\"tabcontent\">\n    ";
}
echo "\n    <select name=\"currency\" onchange=\"javascript: location.href='main2.php?page=netprofit&laoddefaultpage=fileprofit.php&cur='+this.value\">\n        ";
$s = dquery("select id,code from tbl_currencies order by `default` desc");
while ($r = mysqli_fetch_assoc($s)) {
    echo "            <option ";
    if ($cur != "" && $cur == $r["id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["code"];
    echo "</option>\n            ";
}
echo "    </select>\n    ";
$pageid = 443;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
if (isset($cur)) {
    $linked = $cur;
} else {
    $sq = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
    $linked = $sq["id"];
}
$code = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $linked . "'"));
include DATAGRID_DIR . "comm.php";
$sql = "select \nservice_id,\nCONCAT('<a href=\"javascript:load_fromsubpage(\\'editfileservice&id=',service_id,'\\',\\'',service_name,'\\')\">',service_name,'</a>') as service,\nsum(tbl_order_file.credit) as tcredit,count(*) as cnt,\nsum(discount) as tdiscount,\nIF(sum(reseller_credit)>0,sum(reseller_credit),round((sum(tbl_order_file.credit)-sum(discount))," . $precision . ")) as tsell, \nround(sum(tbl_order_file.purchase_cost)," . $precision . ") as tcost ,round(( IF(sum(reseller_credit)>0,sum(reseller_credit), (sum(tbl_order_file.credit)-sum(discount)))-sum(`tbl_order_file`.purchase_cost))," . $precision . ") as profit ,\nCONCAT('<a href=\"javascript:redirectedit(\\'main2.php?page=netprofit&cur=" . $linked . "&page=fileprofitdetail\\',\\'',tbl_order_file.service_id,'&laoddefaultpage=fileprofit.php\\')\">" . $LNG["view"] . " " . $LNG["order"] . "</a>') as action\nfrom tbl_order_file\nLEFT OUTER JOIN tbl_services_file ON\n`tbl_order_file`.service_id = tbl_services_file.id \n where tbl_order_file.purchase_cost!=0 \nand user_can_c=4  and currency_id='" . $linked . "' GROUP BY service_id";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "service_id";
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
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage", "page"];
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
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_services_file`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$fill_from_retail_shop = ["1" => "Yes"];
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
$filtering_fields = ["Order From" => ["type" => "dropdownlist", "table" => "tbl_order_file", "field" => "date", "field_view" => "date", "filter_condition" => "", "order" => "ASC", "source" => $unpaidfrom, "condition" => "", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "cnt" => ["header" => (string) $LNG["orders"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "tcost" => ["header" => $LNG["purchase"] . " " . $LNG["cost"] . " [" . $code["code"] . "]", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => "true"], "tsell" => ["header" => $LNG["selling"] . " " . $LNG["price"] . " [" . $code["code"] . "]", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"], "profit" => ["header" => $LNG["profit"] . " [" . $code["code"] . "]", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_file";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div>\n";
}
echo "\n";
$fileverioncheck = "6.1.0";

?>