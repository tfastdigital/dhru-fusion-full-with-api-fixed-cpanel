<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 498;
checkPagePermission($pageid);
if (!$status || $_ff_onSUBMIT_FILTER && $status || $p && $status) {
    echo "<ul id=\"tabmenu\">     \n    <li><a ";
    if (!$status || $status == "pending") {
        echo " class='tabmenu_active' ";
    }
    echo " onclick=\"getContect('#tab','main2.php?page=utilities.withdrawal&status=pending','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["requset"];
    echo "</a></li>\n    <li><a ";
    if ($status == "accepted") {
        echo " class='tabmenu_active' ";
    }
    echo "  onclick=\"getContect('#tab1','main2.php?page=utilities.withdrawal&status=accepted','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["processed"];
    echo " ";
    echo $LNG["requset"];
    echo "</a></li>      \n   <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
}
if ($status == "accepted") {
    $where = " WHERE status>0";
} else {
    $where = " WHERE status=0";
}
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
$sql = "SELECT *,\n\nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',uid,'\\',\\' ',(SELECT username FROM tblUsers WHERE tblUsers.id=uid),'\\')\">',\n(SELECT username FROM tblUsers WHERE tblUsers.id=uid),'</a>' )  AS user,\nCONCAT(IF(status=0,'Pending',IF(status=1,'Accepted','Rejected'))) as stat,\nCONCAT((select sum(amount) from tbl_withdrawal_transaction where wid=tbl_withdrawal.id),' ',(SELECT code FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid))) as paid ,\nCONCAT(amount,' ',(SELECT code FROM tbl_currencies WHERE tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=uid))) AS code,\n(SELECT value from tbl_paymentgateways  WHERE setting='name'\n and tbl_paymentgateways.gateway=tbl_withdrawal.gateway limit 1) as gatw,\n IF(status=0,CONCAT('<a class=\\'default_dg_a2 editdata\\'\n  onclick=\\'load_subpage(\"main2.php?page=utitlities.editwithdrawal&id=',tbl_withdrawal.id,'\",\"" . $LNG["edit"] . " " . $LNG["withdrawal"] . " " . $LNG["detail"] . "\");\\'>" . $LNG["edit"] . "</a>'),'Processed') AS action\n  ,\n  CONCAT('<a  \n onclick=\"load_subpage(\\'main2.php?page=withdrawal.view&id=',tbl_withdrawal.id,'\\',\\'" . $LNG["view"] . " " . $LNG["transaction"] . "\\');\">" . $LNG["view"] . "</a>')\nas action2\n  FROM tbl_withdrawal " . $where;
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
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Delete Client" => ["view" => false, "flag_name" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete Client"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "status"];
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
$pages_array = ["5" => "5", "10" => "10", "25" => "25", "50" => "50", "100" => "100", "250" => "250", "500" => "500", "1000" => "1000", "5000" => "5000"];
$default_page_size = 50;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$s = dquery("select uid,(select username from tblUsers where tblUsers.id=uid) as user \nfrom tbl_withdrawal group by uid");
while ($r = mysqli_fetch_assoc($s)) {
    $arr[$r["uid"]] = $r["user"];
}
$stat = ["Pending", "Accepted", "Rejected"];
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["User" => ["type" => "dropdownlist", "table" => "tbl_withdrawal", "field" => "uid", "field_view" => "\tuid", "filter_condition" => "", "order" => "ASC", "source" => $arr, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_withdrawal", "field" => "status", "field_view" => "active", "filter_condition" => "", "order" => "ASC", "source" => $stat, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_withdrawal", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_withdrawal", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
if ($status == "" || $status == "pending") {
    $vm_colimns = ["user" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "code" => ["header" => $LNG["total"] . " " . $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "paid" => ["header" => $LNG["paid"] . " " . $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gatw" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "stat" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
} else {
    $vm_colimns = ["user" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "code" => ["header" => (string) $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gatw" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "transactionid" => ["header" => (string) $LNG["invoicestransid"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "note" => ["header" => (string) $LNG["note"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "accept_date" => ["header" => $LNG["process"] . " " . $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "stat" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action2" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
}
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_withdrawal";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (!$status || $_ff_onSUBMIT_FILTER && $status) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";
echo "<br /><br />";

?>