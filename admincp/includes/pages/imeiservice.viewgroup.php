<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER == "Search" || $deleteimeigroup) {
    include "imeiservice.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 34;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if ($deleteimeigroup) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        $numrows = mysqli_num_rows(dquery("select id from tbl_services_imei where group_id='" . $val . "'"));
        if ($val == "1" || $numrows) {
            $error = "<li>" . $LNG["grouphasservices"] . "</li>";
        } else {
            if (dquery("delete from tbl_imei_group where id=" . $val)) {
                $success = (string) $LNG["successfullydeleted"];
            }
        }
    }
}
if ($error) {
    echo "<div id=notification1 class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification1 class=successbox>" . $success . "</div>";
}
$sql = "SELECT tbl_imei_group.id,CONCAT( '<a class=\\'default_dg_a\\' \nhref=\"javascript:load_subpage(\\'main2.php?page=editimeigroup&id=',tbl_imei_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">',group_name,'</a>' )  AS groupname, \nactive,\nCONCAT('<a href=\\'javascript:redirectedit(\\'imeiservice.viewgroup\\',',tbl_imei_group.id,'\\'&sort=\\',tbl_imei_group.display_order)\\'>UP</a>') as display,\nif( active = '1', '" . $img_green . "','" . $img_red . "')  AS flags,\nCONCAT('<a class=\\'default_dg_a2\\' \n\nhref=\"javascript:load_subpage(\\'main2.php?page=editimeigroup&id=',tbl_imei_group.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["group"] . "\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_imei_group";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "display_order";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Delete IMEI Group" => ["view" => true, "flag_name" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete IMEI Group"]];
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
$fill_from_status = ["1" => "Active", "0" => "Inactive"];
$filtering_fields = ["Status" => ["type" => "dropdownlist", "table" => "tbl_imei_group", "field" => "active", "field_view" => "active", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["groupname" => ["header" => (string) $LNG["groupname"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["flags"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_imei_group";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $deleteimeigroup) {
    echo "</div> ";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>