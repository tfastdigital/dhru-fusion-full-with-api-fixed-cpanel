<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 344;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if (isset($_GET["rid"])) {
    echo "<div id='tabcontent'>";
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_mep WHERE ID='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">MEP List</a></li>\n</ul>\n<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"api\"><option value=\"\">";
echo $LNG["none"];
echo "</option>\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "<option value='" . $rowapi["gateway"] . "'>" . $rowapi["value"] . "</option>";
}
echo "    \n</select> &nbsp; <a href=\"#\" data-target=\"apisetting\" data-target-header=\"";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "</a>   </td>\n</tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["mep"];
echo " </td>\n    <td class=\"fieldarea\">\n    <textarea rows=\"5\" cols=\"40\" name=\"mep\"></textarea>\n    <br />\n    <small>";
echo $LNG["moreone"];
echo " ";
echo $LNG["mep"];
echo " ";
echo $LNG["seperated"] . " " . $LNG["by"] . " " . $LNG["newline"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["apiid"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"apiid\" /></td>\n</tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\"> </td>\n    <td class=\"fieldarea\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn add\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','fieldmep','#frm','#notification','true','#main_loader','main2.php?page=mep');\"/> \n</td>\n</tr>\n</tbody>\n</table>\n\n\n</form>\n\n\n</div></div>\n \n";
$sql = "SELECT  tbl_mep.id, \nmep,api,apiid,N_ID,listing,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'includes/pages/editmep.php?id=',tbl_mep.id,'\\', \\'" . $LNG["edit"] . " " . $LNG["mep"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_mep where 1=1 ";
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"], "deleting" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false], "deleting" => ["view" => true, "flag_name" => "deleting", "flag_value" => "yes", "tooltip" => (string) $LNG["deleteselected"]]];
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
$fill_from_status = ["1" => "Enable", "0" => "Disable"];
$api = dquery("select distinct gateway,value from tbl_apiservers,tbl_mep where tbl_apiservers.gateway=tbl_mep.API and tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $fill_from_api[$rowapi["gateway"]] = $rowapi["value"];
}
$filtering_fields = ["MEP" => ["type" => "textbox", "autocomplete" => "false", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_mep", "field" => "mep", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "API" => ["type" => "dropdownlist", "table" => "tbl_mep", "field" => "API", "field_view" => "api", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "mep" => ["header" => (string) $LNG["mep"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "api" => ["header" => (string) $LNG["api"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "apiid" => ["header" => (string) $LNG["apiid"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_mep";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (isset($_GET["rid"])) {
    echo "</div>";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>