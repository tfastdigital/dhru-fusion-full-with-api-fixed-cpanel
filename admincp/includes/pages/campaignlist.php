<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\r\n<div id=\"content\">\r\n    <div id=\"content_padded\">\r\n<script>\r\n    function removeSelecteds()\r\n    {\r\n        \$('input.chk[type=checkbox]').each(function () {\r\n            if(this.checked){\r\n                \$(\".remover\"+\$(this).val()).hide();\r\n                \$.post( \"includes/pages/campaignremove.php?remove=\"+\$(this).val(), function( data ) {\r\n\r\n                });\r\n            }\r\n        });\r\n    }\r\n</script>\r\n        <form id=\"frm\" name=\"\" method=\"post\">\r\n            ";
echo generate_token("form");
echo "\r\n            <div  class=\"groupstabes\" >\r\n\r\n                <div class=\"groupstabescontant\">\r\n\r\n\r\n";
if (!licince\checkSupport()) {
    echo "<div id='notification1' class='errorbox' > Support and Maintenance Required for this features</div>";
    exit;
}
if ($_GET["Delete_Selected"] == "yes") {
    $rid = explode("-", $rid);
    $tr = "";
    foreach ($rid as $r) {
        dquery("delete from tbl_campaign WHERE id='" . $r . "' ");
    }
}
include_once DATAGRID_DIR . "comm.php";
$sql = "SELECT\r\n*,IF(completed!=0 and completed!=total,concat('sending',' [',truncate(100*completed/total,2),'%]'),status) as statuss,\r\n(select count(id) from tbl_campaign_users where campaignid=tbl_campaign.id and opencount>0) as opens,\r\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_subpage(\\'main2.php?page=campaign&edit=',tbl_campaign.id,'\\')\">" . $LNG["edit"] . "</a>') as action_links\r\nFROM tbl_campaign ";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "generate" => ["view" => true, "flag_name" => "Delete Selected", "flag_value" => "yes", "tooltip" => "Delete Selected"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory, true);
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
$default_page_size = $config["adminlistlimit"] ? $config["adminlistlimit"] : 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = false;
$show_search_type = false;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["Active", "Block", "New Registered"];
$fill_from_user_type = ["User", "Reseller", "3" => "Reseller's User"];
$fill_from_tele[0] = "Yes";
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["title" => ["header" => $LNG["campaign"] . " " . $LNG["name"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "subject" => ["header" => (string) $LNG["subject"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "statuss" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "total" => ["header" => "Recipients", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "opens" => ["header" => "Opens", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_campaign";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "\r\n\r\n                </div>\r\n            </div>\r\n        </form>\r\n    </div>\r\n</div>\r\n";
$fileverioncheck = "6.1.0";

?>