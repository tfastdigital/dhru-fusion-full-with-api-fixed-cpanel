<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\r\n    .default_dg_table thead tr th:last-child, #main_tbl thead tr th:last-child{\r\n        width:auto !important\r\n    }\r\n    .dg_right{\r\n        text-align: left !important;\r\n    }\r\n</style>\r\n";
error_reporting(0);
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "<div id=\"tabcontent\">\r\n    ";
}
echo "    <select  name=\"currency\" onchange=\"javascript: location.href='main2.php?page=clientcrdr&cur='+this.value\">\r\n        ";
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
    echo "</option>\r\n            ";
}
echo "    </select>\r\n    ";
$pageid = 442;
checkPagePermission($pageid);
if (isset($cur)) {
    $linked = $cur;
} else {
    $sq = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
    $linked = $sq["id"];
}
$code = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $linked . "'"));
include DATAGRID_DIR . "comm.php";
$sql = "select id,username,credit_left,(select sum(amount) from tbl_statement_user\r\nwhere uid=tblUsers.id and `type`='CR') as crs\r\n ,(select sum(amount) from tbl_statement_user\r\nwhere uid=tblUsers.id and `type`='DR') as drs from \r\ntblUsers where default_currency='" . $linked . "'";
$laoddefaultpage = $page;
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
$filtering_fields = ["Name" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Email" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "email", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "username" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "credit_left" => ["header" => $LNG["available"] . " " . $LNG["credit"] . " [" . $code["code"] . "]", "type" => "label", "width" => "100px", "align" => "left", "wrap" => "nowrap", "text_length" => "40", "case" => "normal"], "crs" => ["header" => $LNG["total"] . " CR[" . $code["code"] . "]", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "drs" => ["header" => $LNG["total"] . " DR[" . $code["code"] . "]", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tblUsers";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div>\r\n";
}
$fileverioncheck = "6.1.0";

?>