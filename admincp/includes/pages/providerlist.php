<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 356;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if (isset($_GET["rid"])) {
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_provider WHERE ID='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
if (isset($_GET["rid"]) || $p || $_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    echo "<ul id=\"tabmenu\"> \n<li><a  onclick=\"getContect('#tab','main2.php?page=countrylist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["countrylist"];
    echo "</a></li> \n<li><a  class='tabmenu_active' onclick=\"getContect('#tab12','main2.php?page=providerlist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["providerlist"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n   <div id='tabcontent'> ";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["api"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"api\" class=\"chosen\" \nonchange=\"javascript:reloadcurrent('countryprovider',this.value+'&laoddefaultpage=providerlist.php');\">\n<option value=\"\">";
echo $LNG["none"];
echo "</option>\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "   <option ";
    if ($id == $rowapi["gateway"]) {
        echo "selected";
    }
    echo " value='";
    echo $rowapi["gateway"];
    echo "'>";
    echo $rowapi["value"];
    echo "</option>\n  ";
}
echo "    \n</select> &nbsp; <a href=\"#\" data-target=\"apisetting\" data-target-header=\"";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "</a>  </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["country"];
echo "  </td>\n    <td class=\"fieldarea\">\n<select name=\"C_ID\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
if ($id) {
    $api = dquery("select * From tbl_provider_country WHERE api='" . $id . "'");
    while ($rowapi = mysqli_fetch_assoc($api)) {
        echo "<option value='" . $rowapi["ID"] . "'>" . $rowapi["Name"] . "</option>";
    }
}
echo "    \n</select>   </td>\n</tr>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["provider"];
echo " </td>\n    <td class=\"fieldarea\">\n    \n    <textarea rows=\"5\" cols=\"40\" name=\"Name\"></textarea>\n    <br>\n    <small>";
echo $LNG["moreone"];
echo " ";
echo $LNG["provider"];
echo " ";
echo $LNG["seperated"] . " " . $LNG["by"] . " " . $LNG["newline"];
echo "</small>\n    </td>\n</tr>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["apiid"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"apiid\" /></td>\n</tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["mepnew"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"mep_new\" /></td>\n</tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["mepold"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"mep_old\" /></td>\n</tr>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn add\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','fieldprovider','#frm','#notification','true','#main_loader','main2.php?page=providerlist');\"/> \n</td>\n</tr>\n</tbody>\n</table>\n\n</form>\n\n\n</div></div>\n \n";
$sql = "SELECT  tbl_provider.ID, \nCONCAT('<a class=\\'default_dg_a2\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editprovider&id=',tbl_provider.ID,'\\', \\'" . $LNG["edit"] . " " . $LNG["provider"] . "\\');    return false;\" >',Name,'</a>') as Name,\napi,apiid,N_ID,listing,C_ID,mep_new,mep_old,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editprovider&id=',tbl_provider.ID,'\\', \\'" . $LNG["edit"] . " " . $LNG["provider"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_provider where 1=1 ";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "ID";
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
$api = dquery("select distinct gateway,value from tbl_apiservers,tbl_provider where tbl_apiservers.gateway=tbl_provider.API and tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $fill_from_api[$rowapi["gateway"]] = $rowapi["value"];
}
$api = dquery("select * From tbl_provider_country");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $fill_from_country[$rowapi["ID"]] = $rowapi["Name"];
}
$filtering_fields = ["Provider" => ["type" => "textbox", "autocomplete" => "false", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_provider", "field" => "Name", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Country" => ["type" => "dropdownlist", "table" => "tbl_provider", "field" => "C_ID", "field_view" => "C_ID", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_country, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "API" => ["type" => "dropdownlist", "table" => "tbl_provider", "field" => "API", "field_view" => "api", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["Name" => ["header" => (string) $LNG["provider"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "api" => ["header" => (string) $LNG["api"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "apiid" => ["header" => (string) $LNG["apiid"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "mep_new" => ["header" => (string) $LNG["mepnew"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "mep_old" => ["header" => (string) $LNG["mepold"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_provider";
$primary_key = "ID";
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