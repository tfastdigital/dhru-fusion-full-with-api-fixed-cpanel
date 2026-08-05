<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER || $p) {
    include "serverservice.head.php";
    echo "<div id=\"tabcontent\">\n";
}
$pageid = 78;
checkPagePermission($pageid);
if ($mode == "deleting") {
    $serv = explode("-", $rid);
    foreach ($serv as $s) {
        if (!mysqli_num_rows(dquery("SELECT order_id FROM tbl_order_server WHERE ( `user_can_c`='0' OR `user_can_c`='1') AND `service_id`='" . $s . "'"))) {
            dquery("DELETE FROM tbl_server_log WHERE `id` ='" . $s . "'");
            $success = "Service Removed Successfully";
        } else {
            $error = "Service has pending Orders";
        }
    }
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
include DATAGRID_DIR . "comm.php";
$sql = "SELECT tbl_server_log.id,CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'editserverservice&id=',tbl_server_log.id,'\\',\\'  ',concat(SUBSTR(tbl_server_log.service_name,1,8),'..'),'\\')\">',service_name,'</a>' )  AS servicename, \ncredit,time,tbl_server_log.active,\n(select value from tbl_apiservers where gateway=API and setting='name') as apiname,\nif(tbl_server_log.active = '1', '" . $img_green . "','" . $img_red . "')  AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'editserverservice&id=',tbl_server_log.id,'\\',\\' ',concat(SUBSTR(tbl_server_log.service_name,1,8),'..'),'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_server_log left outer join tbl_server_group on group_id=tbl_server_group.id where tbl_server_group.active='1'";
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
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false], "deleting" => ["view" => false, "flag_name" => "deleting", "flag_value" => "yes", "tooltip" => (string) $LNG["deleteselected"]]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass"];
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
$fill_from_status = ["1" => "Active", "0" => "Inactvie", "Soft Deleted"];
$result = dquery("select id,group_name from tbl_server_group where active=1 order by display_order");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_group[$row["id"]] = $row["group_name"];
}
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_subscribe = ["1" => "Subscribe"];
$api = dquery("select distinct gateway,value from tbl_apiservers,tbl_server_log where tbl_apiservers.gateway=tbl_server_log.API and tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $fill_from_api[$rowapi["gateway"]] = $rowapi["value"];
}
$fill_from_retail = ["Yes"];
$fill_from_affili = ["Yes"];
$filtering_fields = ["Subscribe" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "subscribe", "field_view" => "subscribe", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_subscribe, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Retail Commision" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "resellerdisc", "field_view" => "resellerdisc", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_retail, "condition" => "", "show_operator" => "false", "default_operator" => ">", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Affiliate Commision" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "affiliate_comission", "field_view" => "affiliate_comission", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_affili, "condition" => "", "show_operator" => "false", "default_operator" => ">", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Service Name" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/serverservice.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_server_log", "field" => "service_name", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "active", "field_view" => "active", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Group Name" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "API" => ["type" => "dropdownlist", "table" => "tbl_server_log", "field" => "API", "field_view" => "API", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Happy Hours From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_server_log", "field" => "happy_hours_start", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "Happy Hours To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_server_log", "field" => "happy_hours_end", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal", "width" => "10px"], "servicename" => ["header" => (string) $LNG["servicename"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "apiname" => ["header" => (string) $LNG["api"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "credit" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_server_log";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"http://kb.dhru.com/Dhru_Fusion/Server_Log_Services/Server_service_overview\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
if ($_ff_onSUBMIT_FILTER || $p) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";
echo "<!--\n<div class=\"add-new\">\n    <a onclick=\"AddnewInpopup(this);\" data-target-header=\"Add Server Service\" data-target=\"serverservice.addnew\" href=\"#\">+</a>\n</div>\n-->";

?>