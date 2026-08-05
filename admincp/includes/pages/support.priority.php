<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER || $p) {
    licince\chkLitePlus();
    licince\chklite();
    echo "<ul id=\"tabmenu\">\n\t<li><a ";
    if (!$defaultloadpage) {
        echo " class='tabmenu_active' ";
    }
    echo "\t\tonclick=\"getContect('#tab','main2.php?page=support.department','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab\">";
    echo $LNG["support"];
    echo " / ";
    echo $LNG["livehelp"];
    echo " ";
    echo $LNG["department"];
    echo "</a></li>\n\t<li><a ";
    if ($defaultloadpage == "support.status.php") {
        echo "\t\tclass='tabmenu_active' ";
    }
    echo "\t\tonclick=\"getContect('#tab1','main2.php?page=support.status','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab1\">";
    echo $LNG["ticket"] . " " . $LNG["status"];
    echo "</a></li>\n\t<li><a ";
    if ($defaultloadpage == "support.priority.php") {
        echo "\t\tclass='tabmenu_active' ";
    }
    echo "\t\tonclick=\"getContect('#tab2','main2.php?page=support.priority','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab2\">";
    echo $LNG["ticket"] . " " . $LNG["priority"];
    echo "</a></li>\n\t<li><a ";
    if ($page == "support.tag") {
        echo "class='tabmenu_active'";
    }
    echo "\t\tonclick=\"getContect('#tab3','main2.php?page=support.tag','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\"\n\t\tid=\"tab3\">";
    echo $LNG["taggenerator"];
    echo "</a></li>\n\t<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\"> ";
}
$pageid = 435;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if (isset($_GET["del"]) || $_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    dquery("DELETE FROM tbl_support_priority WHERE id='" . $_GET["del"] . "'");
    echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
}
echo "<div id=\"notification\"></div>\n\t<div id=\"content\">\n\t\t<div id=\"content_padded\">\n\t\t\t<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\">\n\t\t\t\t\t<h2>\n\t\t\t\t\t\t<img\n\t\t\t\t\t\t\tsrc=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n\t\t\t\t\t\t<span class=\"groupstabesheadertext\">Ticket Priority</span>&nbsp;<font\n\t\t\t\t\t\t\tclass=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n\t\t\t\t\t</h2>\n\t\t\t\t\t<div class=\"groupstabescontant\">\n\n\t\t\t\t\t\t<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\"\n\t\t\t\t\t\t\twidth=\"100%\">\n\t\t\t\t\t\t\t<tbody>\n\n\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldlabel\">";
echo $LNG["ticket"];
echo " ";
echo $LNG["priority"];
echo "</td>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldarea\"><input type=\"text\" name=\"priority\" /></td>\n\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldlabel\">";
echo $LNG["color"];
echo "</td>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldarea\"><input type=\"text\" name=\"color\" /></td>\n\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldlabel\"></td>\n\t\t\t\t\t\t\t\t\t<td class=\"fieldarea\"><input\n\t\t\t\t\t\t\t\t\t\tvalue=\"";
echo $LNG["add"];
echo " ";
echo $LNG["priority"];
echo "\"\n\t\t\t\t\t\t\t\t\t\tid=\"btnaddgroup\" class=\"btn save\" type=\"button\"\n\t\t\t\t\t\t\t\t\t\tonclick=\"SubmitForm ('#btnaddgroup','support.priority','#frm','#notification','true','#main_loader');\" />\n\t\t\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t</tbody>\n\t\t\t\t\t\t</table>\n\t\t\t\t\t</div>\n\t\t\t\t</div>\n\n\t\t\t</form>\n\n\n\t\t</div>\n\t</div>\n\n";
$sql = "SELECT  tbl_support_priority.id, \n\nCONCAT('<span style=\"color:',tbl_support_priority.color,';\">',tbl_support_priority.priority,'</span>') as priority,\nCONCAT('<div style=\"background-color:',tbl_support_priority.color,';height:13px;width:13px;\"></div>') as color,\nIF(id<4,CONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editpriority&id=',tbl_support_priority.id,'\\', \\'" . $LNG["edit"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>')\n   ,CONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editpriority&id=',tbl_support_priority.id,'\\', \\'" . $LNG["edit"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>\n   <a  class=\\'default_dg_a2 deletedata\\' href=\"javascript:\n   if(confirm(\\'Are you sure want to remove Priority ? \\')){\nredirectedit(\\'support.settings\\',\\'&defaultloadpage=support.priority.php&del=',tbl_support_priority.id,'\\');\n   }\n   \">" . $LNG["delete"] . "</a>\n   ')\n  ) as action_links\nFROM tbl_support_priority where 1=1 ";
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
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["priority" => ["type" => "textbox", "autocomplete" => "false", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_support_priority", "field" => "priority", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "priority" => ["header" => $LNG["ticket"] . " " . $LNG["priority"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "color" => ["header" => (string) $LNG["color"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_support_priority";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER || $p) {
    echo "    </div>\n";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>