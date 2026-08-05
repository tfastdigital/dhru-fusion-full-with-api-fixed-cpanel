<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER == "Search" || $mode == "delete" || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 252;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
include_once DATAGRID_DIR2 . "comm.php";
$sql = "SELECT id,date,user_note,type,round(balance,2) as balance,relid,\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\">',tbl_statement_user.ip,'</a>') AS ip,CONCAT(round(amount,2),' ',(select code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=tbl_statement_user.uid))) as amount,IF(LOCATE('invoice',description)>0,CONCAT('<a href=\"javascript: redirectedit(\\'edituser.editinvoice\\',',relid,')\">',relid,'</a>'),IF(stype='server',CONCAT('<a href=\"javascript: redirectedit(\\'edituser.editserverorder\\',',relid,')\">',relid,'</a>'),IF(stype='file',CONCAT('<a href=\"javascript: redirectedit(\\'edituser.editfileorder\\',',relid,')\">',relid,'</a>'),IF(stype='imei',CONCAT('<a href=\"javascript: redirectedit(\\'edituser.editimeiorder\\',',relid,')\">',relid,'</a>'),relid)) )) as relid,IF(admin_note!='',CONCAT(description,'-',admin_note),    if(`data`!='',        if(stype='Transfer',    CONCAT('<a href=\"javascript: load_subpage(\\'main2.php?page=merchantorderdetail&id=',relid,'\\',\\'" . $LNG["order"] . " " . $LNG["detail"] . "\\')\">',tbl_statement_user . description,'</a>')\n    ,\n    CONCAT('<a href=\"javascript: load_subpage(\\'main2.php?page=statementdetail&id=',id,'\\',\\'" . $LNG["transaction"] . " " . $LNG["detail"] . "\\')\">',tbl_statement_user . description,'</a>')\n    )\n    ,description) \n) as description\nFROM tbl_statement_user WHERE uid=" . $id;
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => false, "type" => "image"]];
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
if ($config["adminlistlimit"] && !in_array($config["adminlistlimit"], $pages_array)) {
    $pages_array[$config["adminlistlimit"]] = $config["adminlistlimit"];
}
$default_page_size = $config["adminlistlimit"] ? $config["adminlistlimit"] : 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_type = ["DR" => "DR", "CR" => "CR"];
$fill_from_desc = ["Recharge" => "Recharge", "Credit Apply to" => "Credit Apply to", "New Order Placed" => "New Order Placed", "Credit Added" => "Credit Added", "Credit Rebated" => "Credit Rebated", "Order Rejected" => "Order Rejected", "Add Fund" => "Add Fund", "Reseller Store" => "Reseller Store"];
$filtering_fields = ["Rel ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_statement_user", "field" => "relid", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Type" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "type", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Description" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "description", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_desc, "condition" => "", "show_operator" => "false", "default_operator" => "%like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "description" => ["header" => (string) $LNG["description"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "type" => ["header" => (string) $LNG["type"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "amount" => ["header" => (string) $LNG["amount"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "balance" => ["header" => (string) $LNG["balance"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "user_note" => ["header" => (string) $LNG["note"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "relid" => ["header" => $LNG["related"] . " " . $LNG["id"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "200", "case" => "normal", "source" => $fill_from_status]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_statement_user";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search") {
    echo "</div id=\"tabcontent\"> ";
}
$fileverioncheck = "6.1.0";

?>