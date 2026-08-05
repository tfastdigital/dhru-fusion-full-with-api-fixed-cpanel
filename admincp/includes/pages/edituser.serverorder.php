<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
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
$pageid = 30;
checkPagePermission($pageid);
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT \norder_id,\ndate, \nserver,\n(select value from tbl_apiservers where gateway=(select API\nfrom tbl_server_log where id=service_id) AND setting = 'name') as apiname,\n\nCONCAT('<span> <a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'editserverservice&id=',service_id,'\\',\\' ',(select service_name from tbl_server_log\nwhere id=service_id),'\\')\">','[#',service_id,']</a>  ',(select service_name\nfrom tbl_server_log where id=service_id),'</span>') as service_name, \nIF(user_can_c = 0,'" . $LNG["new"] . "',IF(user_can_c = 1,CONCAT('<span class=textblue>','" . $LNG["inprocess"] . "','</span>'),IF(user_can_c = 3,CONCAT('<span class=textred>','" . $LNG["rejectedorder"] . "','</span>'),CONCAT('<span class=textgreen>','" . $LNG["availableorder"] . "','</span>')))) as status,\nif(verified = '1', '" . $img_black . "',IF(verified = '2','" . $img_gray . "','" . $img_trans . "')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' onclick=\"getContect(\\'#tab12\\',\\'main2.php?page=edituser.editserverorder\\',',order_id,',\\'\\',\\'#tabcontent\\',\\'true\\',\\'#main_loader\\');\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_order_server` \nWHERE user_id =" . $id . " and user_can_c < '5'";
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => false, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => true]];
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
$fill_from_subscribe = ["1" => "Subscribe"];
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$result = dquery("select id,service_name from tbl_server_log");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_service[$row["id"]] = $row["service_name"];
}
$filtering_fields = ["Subscribe" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "subscribe", "field_view" => "subscribe", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_subscribe, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "service_id", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Server" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_server", "field" => "server", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Order Status" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "user_can_c", "field_view" => "user_can_c", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Verification" => ["type" => "dropdownlist", "table" => "tbl_order_server", "field" => "verified", "field_view" => "verified", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_verified, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_server", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_server", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "server" => ["header" => (string) $LNG["server"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "service_name" => ["header" => (string) $LNG["services"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "apiname" => ["header" => (string) $LNG["api"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "150", "case" => "normal"], "status" => ["header" => $LNG["order"] . " " . $LNG["status"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "50", "case" => "normal"], "flags" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_server";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$flags["black"] = $LNG["orderpendingforverification"];
$flags["gray"] = $LNG["orderverified"];
echo displayFlag($flags);
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div> ";
}
$fileverioncheck = "6.1.0";

?>