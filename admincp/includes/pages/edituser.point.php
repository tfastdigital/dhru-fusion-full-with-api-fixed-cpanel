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
$Reward = false;
foreach ($results["addons"] as $k => $addondetail) {
    if ($addondetail["name"] == "Reward Points System" && $addondetail["status"] == "Active") {
        $Reward = true;
    }
}
if (licince\reqaddon("Reward Points System", true)) {
    $User = mysqli_fetch_assoc(dquery("select sum(cr) as crs,sum(dr) as drs from \ntbl_statement_points where uid='" . $id . "'"));
    if ($User["drs"] < $User["crs"]) {
        echo "    <div class=\"info\">Point Balance : <strong style=\"color:green\">";
        echo $User["crs"] - $User["drs"];
        echo "</strong></div>\n    ";
    } else {
        echo "    <div class=\"info\">Point Balance : <strong style=\"color:red\">-";
        echo $User["drs"] - $User["crs"];
        echo "</strong></div>\n    ";
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
    $pageid = 398;
    checkPagePermission($pageid);
    include_once DATAGRID_DIR . "comm.php";
    $sql = "SELECT *,from_unixtime(`time`, '%h:%i %p') as times ,IF(orderid>0,orderid,IF(cr>0,' +Add Fund',' -Rebate Fund')) as orders,(if(cr>0,concat('<span style=\"color:green;\">',cr,'</span>'),concat('<span style=\"color:red;\">-',dr,'</span>'))) as amount  FROM `tbl_statement_points` WHERE uid ='" . $id . "'";
    if ($debug_output) {
        $debug_mode = true;
    } else {
        $debug_mode = false;
    }
    $messaging = true;
    $unique_prefix = "";
    $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
    $default_order_field = "pointid";
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
    $default_page_size = 10;
    $paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
    $dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
    $filtering_option = true;
    $show_search_type = true;
    $dgrid->AllowFiltering($filtering_option, $show_search_type);
    $fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
    $filtering_fields = ["From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_points", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_points", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
    $dgrid->SetFieldsFiltering($filtering_fields);
    $vm_table_properties = ["width" => "100%"];
    $dgrid->SetViewModeTableProperties($vm_table_properties);
    $vm_colimns = ["date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "times" => ["header" => (string) $LNG["time"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "amount" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "120", "case" => "normal"], "orders" => ["header" => (string) $LNG["order"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
    $dgrid->SetColumnsInViewMode($vm_colimns);
    $em_table_properties = ["width" => "75%"];
    $dgrid->SetEditModeTableProperties($em_table_properties);
    $dm_table_properties = ["width" => "60%"];
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
    $table_name = "tbl_statements_points";
    $primary_key = "id";
    $condition = "";
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
    $dgrid->WriteCssClass();
    $dgrid->Bind();
    if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
        echo "</div> ";
    }
    $fileverioncheck = "6.1.0";
} else {
    echo "    <div class=\"error\">Reward point addon is not enabled</div>\n    ";
    exit;
}

?>