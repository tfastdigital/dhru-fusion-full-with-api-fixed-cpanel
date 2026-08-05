<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .default_dg_table thead tr th:last-child, #main_tbl thead tr th:last-child{\n        width:auto !important\n    }\n</style>\n";
if ($p) {
    echo "    <ul id=\"tabmenu\">\n        ";
    if (!$OnlyEcommerce) {
        echo "            <li><a ";
        if ($laoddefaultpage == "imeistatus.php" || !$laoddefaultpage) {
            echo "class='tabmenu_active'";
        }
        echo "   onclick=\"getContect('#tab','main2.php?page=imeistatus','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
        echo $LNG["imei"];
        echo " ";
        echo $LNG["status"];
        echo "</a></li>\n            <li><a ";
        if ($laoddefaultpage == "serverstatus.php") {
            echo "class='tabmenu_active'";
        }
        echo " onclick=\"getContect('#tab3','main2.php?page=serverstatus&laoddefaultpage=serverstatus.php','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
        echo $LNG["server"];
        echo " ";
        echo $LNG["with"];
        echo " ";
        echo $LNG["api"];
        echo " ";
        echo $LNG["status"];
        echo "</a></li>\n        ";
    }
    echo "        <li><a ";
    if ($laoddefaultpage == "productstatus.php") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab4','main2.php?page=productstatus&laoddefaultpage=productstatus.php','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["product"];
    echo " ";
    echo $LNG["status"];
    echo "</a></li>\n        <div style=\"clear: both;\"></div>\n    </ul>\n<div id=\"tabcontent\">\n\n    ";
}
include DATAGRID_DIR . "comm.php";
$sql = "SELECT \nCONCAT('<a href=\"javascript:load_fromsubpage(\\'editimeiservice&id=',tbl_services_imei.id,'\\',\\' ',tbl_services_imei.service_name,'\\')\">'\n,service_name,'</a>') as service_name\n,CONCAT((select count(order_id) from tbl_order_imei where service_id=id)) as orders,\nviewer,\n(select count(tbl_review.id) from tbl_review where lid=id) as reviews\n from tbl_services_imei where useasserver=2\nHAVING orders>0\n";
$laoddefaultpage = "imeistatus.php";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "sort";
$default_order_type = "ASC";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false]];
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
$sql = dquery("SELECT `id`,`group_name` FROM `tbl_imei_group` WHERE `server`=2");
while ($rows = mysqli_fetch_assoc($sql)) {
    $group[$rows["id"]] = $rows["group_name"];
}
$filtering_fields = ["Status" => ["type" => "dropdownlist", "table" => "tbl_services_imei", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service_name" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "orders" => ["header" => (string) $LNG["orders"], "width" => "180px", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal", "summarize" => "true"], "viewer" => ["header" => (string) $LNG["view"], "width" => "180px", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "reviews" => ["header" => (string) $LNG["reviews"], "width" => "80px", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_imei";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($p) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>