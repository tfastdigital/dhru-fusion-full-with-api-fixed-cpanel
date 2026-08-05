<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getSupplierDetails($_SESSION["supid"]);
$id = $_SESSION["supid"];
include_once DATAGRID_DIR . "comm.php";
$cur = dquery("SELECT *\nFROM tbl_currencies\nORDER BY `default` DESC ");
while ($rc = mysqli_fetch_assoc($cur)) {
    $imeicnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_imei where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $filecnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_file where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $sercnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_server where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    $shopcnt = mysqli_fetch_assoc(dquery("SELECT count(order_id) as cnt,\n    sum(purchase_cost) as tot from tbl_order_product where reply_by_sup='" . $id . "'\n     AND user_can_c='4' and currency_id='" . $rc["id"] . "'"));
    if ($_SESSION["currency"]["id"] != $rc["id"]) {
        $imeicnt["tot"] = convertCurrency($imeicnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $filecnt["tot"] = convertCurrency($filecnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $sercnt["tot"] = convertCurrency($sercnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
        $shopcnt["tot"] = convertCurrency($shopcnt["tot"], $rc["id"], $_SESSION["currency"]["id"]);
    }
    $oi += $imeicnt["cnt"];
    $of += $filecnt["cnt"];
    $os += $sercnt["cnt"];
    $oh += $shopcnt["cnt"];
    $imeitot += $imeicnt["tot"];
    $filetot += $filecnt["tot"];
    $servertot += $sercnt["tot"];
    $shoptot += $shopcnt["tot"];
}
$paid = mysqli_fetch_assoc(dquery("SELECT sum(amount) as tot \n        from tbl_statement_supplier where supplier_id='" . $id . "'"));
$ded = $paid["tot"] - ($imeitot + $filetot + $servertot + $shoptot);
echo "<div id=\"notification\"></div>\n<div id=\"content\"><div id=\"content_padded\">\n        <table class=\"form\" border=\"0\" cellpadding=\"2\" cellspacing=\"2\" width=\"100%\">\n            <tbody>\n            <tr>\n                <td class=\"fieldarea\" colspan=\"2\" >Total Order Proceed : ";
echo $oi + $of + $os + $oh;
echo " </td><td width=\"85%\"  class=\"fieldarea\">";
echo $imeitot + $filetot + $servertot + $shoptot;
echo " ";
echo $config["base_currency"];
echo "</td>\n            </tr>\n            <tr>\n                <td class=\"fieldarea\" colspan=\"2\" >";
echo $LNG["total"];
echo " ";
echo $LNG["payout"];
echo "  </td><td width=\"85%\"  class=\"fieldarea\">";
echo $paid["tot"];
echo " ";
echo $config["base_currency"];
echo "</td>\n            </tr>\n            <tr>\n                <td class=\"fieldarea\" colspan=\"2\" >\n        ";
if (0 <= $ded) {
    echo "<div style='color:green'>Credit Balance: ";
} else {
    echo "<div style='color:red'>Pending Payout: ";
}
echo "</div> </td><td width=\"85%\"  class=\"fieldarea\">";
if (0 <= $ded) {
    echo "<div style='color:green'>";
    $flag = 0;
} else {
    echo "<div style='color:red'>";
    $flag = 1;
}
echo " ";
echo $paid["tot"];
echo " - ";
echo $imeitot + $filetot + $servertot + $shoptot;
echo " = ";
echo $ded;
echo "  ";
echo $config["base_currency"];
echo "        ";
if ($flag) {
    echo "            <form method=\"post\" id=\"frmpa\">\n                <input type=\"hidden\" name=\"payout\" value=\"";
    echo abs($ded);
    echo "\" />\n                <input type=\"button\" name=\"payout\" id=\"payout\" value=\"Request For Payout\"\n                       onclick=\"SubmitForm ('#payout','requestpayout','#frmpa','#notification','true','#main_loader');\"/>\n            </form>\n            ";
}
echo "</div>\n</td>\n</tr>\n</tbody>\n<tbody><tr></tr>\n</tbody>\n</table>\n</div>\n";
$sql = "SELECT id,date,description,ptype,tid,ip,amount,relid\nFROM tbl_statement_supplier WHERE tbl_statement_supplier.supplier_id='" . $id . "'";
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
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false]];
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
$fill_from_type = ["DR" => "DR", "CR" => "CR"];
$filtering_fields = ["Type" => ["type" => "dropdownlist", "table" => "tbl_statement_supplier", "field" => "type", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_supplier", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_supplier", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => "#ID", "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => "Date", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "description" => ["header" => "Description", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "ptype" => ["header" => "Type", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "tid" => ["header" => "TransactionID", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "amount" => ["header" => "Amount [" . $config["base_currency"] . "]", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_statement_supplier";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "\n";

?>