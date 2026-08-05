<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\r\n\r\n<ul id=\"tabmenu\"> \r\n<li class=\"tabmenu-header\"><span>Submenu</span></li>\r\n<li><a ";
if ($defaultloadpage != "apisetting.php") {
    echo "class=tabmenu_active";
}
echo " onclick=\"getContect('#tab','main2.php?page=apisetting','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >APi</a></li>\r\n\r\n<li><a onclick=\"getContect('#tab22','main2.php?page=inactiveapisetting','','','#tabcontent',true,'#main_loader');\"\r\n           id=\"tab22\">+Add APi</a></li>\r\n<li><a\r\n onclick=\"getContect('#tab2','main2.php?page=cronsetting','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >Cron Settings</a></li>\r\n\r\n    <li><a class='tabmenu_active'\r\n           onclick=\"getContect('#tab4','main2.php?page=croninstall','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >Cron Auto Install</a></li>\r\n\r\n\r\n    <li><a onclick=\"getContect('#tab3','main2.php?page=apisynchistory','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >APi Sync ";
echo $LNG["history"];
echo "</a></li>\r\n\r\n <div style=\"clear: both;\"></div>  \r\n</ul>\r\n";
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT *,\r\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\">',ip,'</a>') AS ips,IF((select value from tbl_apiservers where gateway=`server` and setting='customname')!='',concat((select value from tbl_apiservers where gateway=`server` and setting='customname'),' [',(select value from tbl_apiservers where gateway=`server` and setting='name'),']'),(select value from tbl_apiservers where gateway=`server` and setting='name') )as apisync ,(select username from tbl_admin where id=adminid) as admin,DATE_FORMAT(FROM_UNIXTIME(`time`), '%e %b %Y %h hr %m min') AS dates FROM tbl_api_sync_log where 1=1 ";
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"], "deleting" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = false;
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
$default_page_size = 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = false;
$show_search_type = false;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["1" => "Enable", "0" => "Disable"];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["apisync" => ["header" => "Server", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ips" => ["header" => "ip", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "dates" => ["header" => "Time", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "admin" => ["header" => "Admin", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "apiid" => ["header" => (string) $LNG["apiid"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "event" => ["header" => (string) $LNG["event"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_provider_country";
$primary_key = "ID";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (isset($_GET["rid"]) || $p) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";
echo "</div>";

?>