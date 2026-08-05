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
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
if (!$nottab) {
    echo "<ul id=\"tabmenu\">     \n    <li><a  onclick=\"getContect('#tab','main2.php?page=ebayorder&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["create"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab1','main2.php?page=ebayorderlist&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>      \n    <li><a  class='tabmenu_active'   onclick=\"getContect('#tab3','main2.php?page=ebayorderused&nottab=1','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["used"];
    echo " ";
    echo $LNG["order"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n   <div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
}
if ($ids) {
    dquery("DELETE FROM `tbl_private_order`  WHERE `id`='" . $ids . "'");
    echo "<div id='notification1' class='successbox' >" . $LNG["link"] . " " . $LNG["deleted"] . " " . $LNG["successfully"] . " </div>";
}
$sql = "SELECT *,(select service_name from tbl_services_imei where tbl_services_imei.id=sid)\n as service,IF((select useasserver from tbl_services_imei\n where id=sid)=1,'Server','IMEI') as type\n ,date,\n(select username from tblUsers where tblUsers.email=tbl_private_order.email limit 1) as username \n,\nCONCAT('<a class=\\'default_dg_a\\' \nhref=\"javascript:load_subpage(\\'main2.php?page=imeiorder.history&direct=',id,'\\', \\'Direct IMEI Orders\\')\">View Order</a>' ) \n AS vieworder,\n \n CONCAT('<a class=\\'default_dg_a editdata\\' \n href=\"javascript:load_subpage(\\'main2.php?page=editebayorder&id=',id,'\\',\\'Edit Direct Order\\');\">\n Edit\n </a> \n<a class=\\'deletedata\\'\nhref=\"javascript:\nif(confirm(\\'Are you sure want to Remove ?\\')){\nreloadcurrent(\\'ebayorder&ids=',id,'&seltab=2&loadpage=includes/pages/ebayorderused.php\\',\\'" . $row["id"] . "\\');\n}\n\" >Remove</a>') AS actionlink FROM tbl_private_order WHERE qnt='0'";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Delete Client" => ["view" => false, "flag_name" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete Client"]];
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
$default_page_size = 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["Active", "Block", "New Registered"];
$fill_from_user_type = ["User", "Reseller", "3" => "Reseller's User"];
$result = dquery("select code,id from tbl_currencies");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_currency[$row["id"]] = $row["code"];
}
$result = dquery("select username,id from tblUsers where usertype=1");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_reseller[$row["id"]] = $row["username"];
}
$fill_signup = ["" => "Normal signup", "quick" => "Quick Checkout", "direct" => "Direct Order"];
$sl = dquery("select id,service_name from tbl_services_imei");
while ($r = mysqli_fetch_assoc($sl)) {
    $fill_service[$r["id"]] = $r["service_name"];
}
$filtering_fields = ["Service" => ["type" => "dropdownlist", "table" => "tbl_private_order", "field" => "sid", "field_view" => "sid", "filter_condition" => "", "order" => "ASC", "source" => $fill_service, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_private_order", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_private_order", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "type" => ["header" => (string) $LNG["type"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "30", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "vieworder" => ["header" => (string) $LNG["orders"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "actionlink" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
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