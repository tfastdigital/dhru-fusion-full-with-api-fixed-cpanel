<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"javascript:void(0);\">Credit Report</a></li>\n</ul>\n<select name=\"currency\" onchange=\"javascript: location.href='main2.php?page=creditreport&cur='+this.value\">\n";
$s = dquery("select id,code from tbl_currencies order by `default` desc");
while ($r = mysqli_fetch_assoc($s)) {
    echo "<option ";
    if ($cur != "" && $cur == $r["id"]) {
        echo "selected";
    }
    echo "        value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["code"];
    echo "</option>\n";
}
echo "</select>\n<style>\nth.dg_right{\n    font-size: 15px !important;\n    text-indent: 0px;\n}\n</style>\n";
$pageid = 493;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if (isset($cur)) {
    $linked = $cur;
} else {
    $sq = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
    $linked = $sq["id"];
}
$code = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $linked . "'"));
$totals = mysqli_fetch_assoc(dquery("select sum(credit_left) as cleft,\nsum(credit_used) as used,sum(credit_inprocess) as process,(select\nsum(amount) from tbl_statement_user where uid in (select id from \ntblUsers where default_currency='" . $linked . "') and \n`type`='CR' and description like '%Add Fund%') as recharge\nfrom tblUsers where default_currency='" . $linked . "'"));
echo "<table style=\"font-size: 16px;\">\n    <tr>\n        <th>";
echo $LNG["total"];
echo " ";
echo $LNG["balance"];
echo " : ";
echo round($totals["cleft"], 2);
echo "</th>\n        <th>";
echo $LNG["total"];
echo " ";
echo $LNG["used"];
echo " : ";
echo round($totals["used"], 2);
echo "</th>\n        <th>";
echo $LNG["total"];
echo " ";
echo $LNG["inprocess"];
echo " : ";
echo round($totals["process"], 2);
echo "</th>\n        <th>";
echo $LNG["total"];
echo " ";
echo $LNG["recharge"];
echo " : ";
echo round($totals["recharge"], 2);
echo "</th>\n    </tr>\n</table>\n";
$sql = "SELECT\ntblUsers.id, \nusername,email,\nround(credit_left,2) as credit_left,\nround(credit_used,2) as credit_used,\nround(credit_inprocess) as credit_inprocess,\n(SELECT SUM(amount) FROM tbl_statement_user WHERE uid=tblUsers.id and\n type='CR' and description LIKE '%Add Fund%') AS recharge\nFROM tblUsers where default_currency='" . $linked . "'";
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
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false]];
$dgrid->SetMultirowOperations($multirow_operations);
if ($cur) {
    $http_get_vars = ["page", "accesskey", "display_errors", "pass", "cur"];
} else {
    $http_get_vars = ["page", "accesskey", "display_errors", "pass"];
}
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
$result = dquery("select username,id from tbl_admin");
while ($row = mysqli_fetch_assoc($result)) {
    $admin[$row["id"]] = $row["username"];
}
$filtering_fields = ["Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "credit_left" => ["header" => $LNG["balance"] . " " . $LNG["left"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "555", "case" => "normal", "summarize" => true], "credit_used" => ["header" => $LNG["creditused"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => true], "credit_inprocess" => ["header" => $LNG["inprocess"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => true], "recharge" => ["header" => $LNG["recharge"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => true]];
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
$fileverioncheck = "6.1.0";

?>