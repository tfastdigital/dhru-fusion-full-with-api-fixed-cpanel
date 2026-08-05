<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
echo "\n<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n \n  <div class=\"groupstabescontant\">\n   \n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>    \n    <span class=\"groupstabesheadertext\">Site Information</span>\n  </h2>\n<form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\"/>\n<table class=\"form\" border=\"0\"  cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["pending"];
echo " ";
echo $LNG["payout"];
echo "</td>\n    <td class=\"fieldarea\">\n    \t\t";
echo $clientDetails["affiliate_balance"] - $clientDetails["affiliate_payout"];
echo " ";
echo $clientDetails["currency"]["code"];
echo " \t</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["amount"];
echo "</td>\n    <td class=\"fieldarea\">\n    \t\t<input type=\"text\"  name=\"amount\" /> ";
echo $clientDetails["currency"]["code"];
echo " \t</td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["payout"];
echo " ";
echo $LNG["type"];
echo "</td>\n    <td class=\"fieldarea\">\n    \t<select name=\"ptype\">\n    \t\t<option value='paypal'>Paypal</option>\n    \t\t<option value='addtocredit'>Add To Credit</option>\n    \t\t<option value='other'>Other</option>\n    \t</select>\n    </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["notes"];
echo "</td>\n    <td class=\"fieldarea\">\n    \t\t<textarea name=\"note\" ></textarea>\n \t</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["transaction"];
echo " ";
echo $LNG["id"];
echo "</td>\n    <td class=\"fieldarea\">\n    \t\t<input type=\"text\"  name=\"transactionid\" /> \n \t</td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"btn save\" type=\"button\" \nonclick=\"SubmitForm ('#btnedituser','edituser.payout','#frmedituser','#notification','true','#main_loader','main2.php?page=edituser.payout','";
echo $id;
echo "');\"/> \t</td>\n</tr>\n</tbody>\n</table>\n</div>\n\n\n</form>\n</div></div></div>\n\n";
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT\ntbl_affiliate_payout.id,transactionid,\namount,ptype,note,from_unixtime(time,'%Y-%m-%d') as dat\nFROM tbl_affiliate_payout WHERE tbl_affiliate_payout.aid=" . $id;
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Cancel selected" => ["view" => false, "flag_name" => "cancelinvoice", "flag_value" => "yes", "tooltip" => "Cancel selected"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "by"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory);
$exporting_types = ["excel" => "false", "pdf" => "false", "xml" => "false"];
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
$fill_from_subscribe = ["paypal" => "Paypal", "addtocredit" => "Add To Cart", "other" => "Other"];
$code = $clientDetails["currency"]["code"];
$filtering_fields = ["Payment Type" => ["type" => "dropdownlist", "table" => "tbl_affiliate_payout", "field" => "ptype", "field_view" => "subscribe", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_subscribe, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Transaction ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_affiliate_payout", "field" => "transactionid", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["dat" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "transactionid" => ["header" => $LNG["transaction"] . " " . $LNG["id"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "amount" => ["header" => $LNG["amount"] . " [" . $code . "]", "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "ptype" => ["header" => (string) $LNG["type"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "note" => ["header" => (string) $LNG["note"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_affiliate_payout";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) {
    echo "</div> ";
}
echo "\n\n\n";
$fileverioncheck = "6.1.0";

?>