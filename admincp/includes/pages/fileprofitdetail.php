<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include "profit.head.php";
echo "\t<div id=\"tabcontent\">\n<style>\nth.dg_right{\n    font-size: 15px !important;\n    text-indent: 0px;\n}\n</style>\n";
if (trim($cur)) {
    $code = mysqli_fetch_assoc(dquery("select code from\n tbl_currencies where id='" . $cur . "'"));
} else {
    $code = mysqli_fetch_assoc(dquery("select code,id from\n    tbl_currencies where `default`=1"));
    $cur = $code["id"];
}
include DATAGRID_DIR . "comm.php";
$sql = "select \nservice_id,order_id,file,\nCONCAT( '<a class=\\'default_dg_a\\' \nhref=\"javascript:redirectedit(\\'edituser\\', ', user_id, ')\">',username,'</a>' )  AS user,\npurchase_cost,date,\nIF(reseller_credit>0,reseller_credit,(credit-discount)) as sell,\n( IF(reseller_credit>0,reseller_credit, (credit-discount)) -purchase_cost) as profit \nfrom tbl_order_file AS R\n     LEFT JOIN tblUsers AS N\n    ON R.user_id = N.id where purchase_cost!=0 and user_can_c=4 and service_id='" . $id . "'  and currency_id='" . $cur . "' \n";
$laoddefaultpage = $page;
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
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "cur"];
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
$fill_from_retail_shop = ["1" => "Yes"];
$filtering_fields = ["Name" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "N", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "R", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "R", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "file" => ["header" => (string) $LNG["file"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "purchase_cost" => ["header" => $LNG["purchase"] . " " . $LNG["cost"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"], "sell" => ["header" => $LNG["selling"] . " " . $LNG["price"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"], "profit" => ["header" => $LNG["profit"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"]];
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
echo "\t\n\t</div>\n";
$fileverioncheck = "6.1.0";

?>