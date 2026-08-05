<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n";
include "supplier.head.php";
echo "<style>\n    .imei,.file,.server,.shop{height:15px;width:15px;float: left;margin:3px}\n    .imei{background: #F0AA65;}\n    .file{background: #c4bfd9;}\n    .server{background: #90c0db;}\n    .shop{background: #a4cc8a;}\n</style>\n";
licince\chkLitePlus();
licince\chklite();
$pageid = 285;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR . "comm.php";
if (!$OnlyEcommerce) {
    $sql = "SELECT \nid,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'pos.editsupplier&id=',tbl_supplier.id,'\\',\\' ',tbl_supplier.username,'\\')\">',username,'</a>' )  AS username,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"mailto:',email,'\">',email,'</a>' )  AS email,\nuserstatus ,\nCONCAT(IF(tbl_supplier.imei_limit_left = '-1','Unlimited',tbl_supplier.imei_limit_left)) AS limits,\nCONCAT(IF(tbl_supplier.file_limit_left = '-1','Unlimited',tbl_supplier.file_limit_left)) AS limits1,\nCONCAT(IF(tbl_supplier.server_limit_left = '-1','Unlimited',tbl_supplier.server_limit_left)) AS limits2,\nCONCAT(if( tbl_supplier.imei_service_access  = '1','<div class=\"imei\" title=\"IMEI Access\"></div>',''),'',if( tbl_supplier.file_service_access  = '1','<div class=\"file\" title=\"File Access\"></div>',''),'',if( tbl_supplier.server_log_access  = '1','<div class=\"server\" title=\"Server Access\"></div>',''),'',if( tbl_supplier.shop_service_access  = '1','<div class=\"shop\" title=\"Shop Access\"></div>','')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'pos.editsupplier&id=',tbl_supplier.id,'\\',\\' ',tbl_supplier.username,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_supplier` WHERE 1=1 ";
} else {
    $sql = "SELECT \nid,\nCONCAT('<a class=\\'default_dg_a2\\' href=\"javascript:load_fromsubpage(\\'pos.editsupplier&id=',tbl_supplier.id,'\\',\\' ',tbl_supplier.username,'\\')\">',username,'</a>') as username,\nCONCAT( '<a class=\\'default_dg_a\\' href=\"mailto:',email,'\">',email,'</a>' )  AS email,\nuserstatus ,\nCONCAT(IF(tbl_supplier.imei_limit_left = '-1','Unlimited',tbl_supplier.imei_limit_left)) AS limits,\nCONCAT(IF(tbl_supplier.file_limit_left = '-1','Unlimited',tbl_supplier.file_limit_left)) AS limits1,\nCONCAT(IF(tbl_supplier.server_limit_left = '-1','Unlimited',tbl_supplier.server_limit_left)) AS limits2,\nCONCAT(if(tbl_supplier.shop_service_access  = '1','<div class=shop></div>','')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'pos.editsupplier&id=',tbl_supplier.id,'\\',\\' ',tbl_supplier.username,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_supplier` WHERE 1=1 ";
}
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
$dgrid->safeMode = false;
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => true], "details" => ["view" => false]];
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
$fill_from_status = ["1" => "Active", "0" => "Bloack"];
$filtering_fields = ["ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_supplier", "field" => "id", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/supplierlist.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_supplier", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_supplier", "field" => "userstatus", "field_view" => "userstatus", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["access"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_supplier";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "\n</div>";
$fileverioncheck = "6.1.0";

?>