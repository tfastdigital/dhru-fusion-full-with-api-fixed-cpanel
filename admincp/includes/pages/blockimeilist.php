<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include DATAGRID_DIR . "comm.php";
if ($id) {
    echo "    <div  class=\"groupstabes\" >\r\n        <h2>\r\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\r\n            <span class=\"groupstabesheadertext\">Add IMEIs</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\r\n        </h2>\r\n        <div class=\"groupstabescontant\">\r\n            <form method=\"post\" id=\"frmsb\">\r\n                <input type=\"hidden\" name=\"imeiservice\" value=\"";
    echo $id;
    echo "\" />\r\n                <input type=\"hidden\" name=\"reload\" value=\"1\" />\r\n                <table class=\"form\">\r\n                    <tbody>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\">";
    echo $LNG["add"];
    echo " IMEI </td>\r\n                        <td class=\"fieldarea\"><textarea name=\"imei\" style=\"height: 150px;\" rows=\"5\"></textarea>\r\n                            <small>each imei new line </small> </td>\r\n                    </tr>\r\n                    <tr>\r\n                        <td class=\"fieldlabel\"></td>\r\n                        <td class=\"fieldarea\">\r\n                            <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnaddgroup\" class=\"btn\" type=\"button\"\r\n                      onclick=\"SubmitForm('#btnaddgroup','blockimei','#frmsb','#notification','true','#main_loader','','',1);\"/>\r\n                        </td>\r\n                    </tr>\r\n                    </tbody></table>\r\n\r\n            </form>\r\n        </div></div>\r\n\r\n";
    $Where = " and service_id='" . $id . "'";
}
$sql = "SELECT\r\nid,imei,reason,IF(service_id>0,(select service_name from tbl_services_imei where id=service_id),'All Service') as service\r\nFROM tbl_blacklist_imei WHERE 1=1 " . $Where;
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
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => true]];
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
$result = dquery("select id,service_name from tbl_services_imei");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_status[$row["id"]] = $row["service_name"];
}
$fill_from_admin = $admin;
$fill_from_discription = $discription;
$filtering_fields = ["File" => ["type" => "dropdownlist", "table" => "tbl_blacklist_imei", "field" => "service_id", "field_view" => "service_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["imei" => ["header" => "IMEI", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "reason" => ["header" => (string) $LNG["reason"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_blacklist_imei";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";
echo "<script>\r\n    \$( document ).ready(function() {\r\n        \$(\".colorpicker\").hide();\r\n    });\r\n\r\n</script>\r\n";

?>