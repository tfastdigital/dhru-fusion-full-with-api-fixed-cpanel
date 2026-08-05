<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .boxes{\n        width: 10px;\n        height: 10px;\n        float:left;\n        margin-top: 4px;\n        margin-right: 4px;\n    }\n</style>\n";
$pageid = 475;
checkPagePermission($pageid);
$supplieraccess = true;
include ROOTDIR . "/includes/clients.fun.inc.php";
if ($acceptall) {
    if (!isset($show)) {
        $order = dquery("SELECT `order_id` FROM `tbl_order_file` WHERE  `user_can_c`='0'");
        while ($rows = mysqli_fetch_assoc($order)) {
            $_order[] = $rows["order_id"];
        }
        if ($_order) {
            $order = implode(",", $_order);
            $_SESSION["tmp_orders"] = $order;
            dquery("update `tbl_order_file` set `user_can_c`='1',acceptedby='" . $_SESSION["adminid"] . "' where `order_id` IN (" . $order . ") AND `user_can_c`='0'");
            $success = $LNG["orderaccepted"];
        } else {
            $order = $_SESSION["tmp_orders"];
        }
    } else {
        $order = $_SESSION["tmp_orders"];
    }
    include "quickacceptedfileorder.php";
    exit;
}
if ($rejectorder) {
    include_once ROOTDIR . "/includes/fileservices.fun.php";
    $order = explode("-", $rid);
    foreach ($order as $o) {
        rejectFile(md5($o), $LNG["rejectedorder"] . " " . $LNG["byadmin"], $_SESSION["adminid"]);
    }
    echo "<div id=notification1 class=successbox>" . $LNG["order"] . " " . $LNG["rejectedorder"] . " " . $LNG["successfully"] . "</div>";
}
if ($acceptorder) {
    $order = str_replace("-", ",", $rid);
    dquery("update `tbl_order_file` set `user_can_c`='1',acceptedby='" . $_SESSION["adminid"] . "' where `order_id` IN (" . $order . ") AND `user_can_c`='0'");
    $success = $LNG["orderaccepted"];
    include "quickacceptedfileorder.php";
    exit;
}
include DATAGRID_DIR . "comm.php";
$sql = "SELECT \norder_id,\ndate, \nfile,\n    \n   (select value from tbl_apiservers where gateway=(select API\nfrom tbl_services_file where id=service_id) AND setting = 'name') as apiname,\n(select API from tbl_services_file where id=service_id) as API,\n\n\nCONCAT(credit-discount) as total,\nCONCAT((credit-discount),(SELECT suffix FROM tbl_currencies where id=tblUsers.default_currency)) AS credit,\nconcat('<div class=\"boxes\" style=\"background-color: ',(SELECT `colortag` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id),'\"></div>',(SELECT `service_name` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id)) as service,\n(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_file.user_id) as username\n\nFROM `tbl_order_file` LEFT OUTER JOIN tblUsers ON\n`tbl_order_file`.user_id = tblUsers.id where user_can_c='0'";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "order_id";
if ($config["orderdisplay"] == 2) {
    $default_order_type = "ASC";
} else {
    $default_order_type = "DESC";
}
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Accept Order" => ["view" => true, "flag_name" => "acceptorder", "flag_value" => "yes", "tooltip" => (string) $LNG["acceptselected"]], "Accept All" => ["view" => true, "flag_name" => "acceptall", "flag_value" => "yes", "tooltip" => (string) $LNG["acceptall"], "skipselectedrow" => true], "Reject Order" => ["view" => true, "flag_name" => "rejectorder", "flag_value" => "yes", "tooltip" => "Reject Selected"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage"];
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
$pages_array = ["500" => "500", "1000" => "1000", "1500" => "1500", "2000" => "2000", "2500" => "2500"];
$default_page_size = 500;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT * from tbl_services_file WHERE id IN (select service_id FROM tbl_order_file where user_can_c='0' group by service_id)");
while ($row = mysqli_fetch_assoc($sql)) {
    $arrfrom[$row["id"]] = $row["service_name"];
}
$api = dquery("select distinct gateway,value from tbl_apiservers,tbl_services_file where tbl_apiservers.gateway=tbl_services_file.API and tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $gp = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n    where gateway='" . $rowapi["gateway"] . "' and setting='customname'"));
    $fill_from_api[$rowapi["gateway"]] = $rowapi["value"] . " " . $gp["value"];
}
if (!count($fill_from_api)) {
    $fill_from_api[1] = "";
}
if ($supplieraccess) {
    $filtering_fields = ["file" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_file", "field" => "file", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "API" => ["type" => "dropdownlist", "table" => "tbl_order_file", "field" => "API", "field_view" => "API", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "subquery" => "(SELECT API FROM tbl_services_file WHERE id = service_id)", "show_operator" => "false", "default_operator" => "subquery", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
} else {
    $filtering_fields = ["Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_file", "field" => "service_id", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => "", "source" => $arrfrom], "API" => ["type" => "dropdownlist", "table" => "tbl_order_file", "field" => "API", "field_view" => "API", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "subquery" => "(SELECT API FROM tbl_services_file WHERE id = service_id)", "show_operator" => "false", "default_operator" => "subquery", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "file" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_file", "field" => "file", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_file", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
}
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["order_id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "apiname" => ["header" => (string) $LNG["api"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "credit" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "file" => ["header" => (string) $LNG["file"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "username" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
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
$fileverioncheck = "6.1.0";

?>