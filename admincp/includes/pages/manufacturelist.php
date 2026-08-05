<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction newWindow(file,window)\n {msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n } \n</script>\n";
if ($p || $_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    echo "<ul id=\"tabmenu\"> \n<li><a class='tabmenu_active'  onclick=\"getContect('#tab','main2.php?page=manufacturelist','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["manufacture"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li> \n<li><a  onclick=\"getContect('#tab12','main2.php?page=warehouselist','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["warehouse"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n   <div id='tabcontent'> ";
}
$pageid = 353;
checkPagePermission($pageid);
include_once DATAGRID_DIR . "comm.php";
if (isset($_GET["rid"])) {
    echo "<div id='tabcontent'>";
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_manufacture WHERE ID='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["manufacture"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"name\" /></td>\n</tr>\n\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\">";
echo $LNG["image"];
echo " ";
echo $LNG["link"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"image_link\" id=\"image_link\"/><input class=\"addFromgallery\" value=\"";
echo $LNG["add"];
echo "\" type=\"button\" name=\"add\" onclick=\"newWindow('includes/gallery.php?id=image_link', 'windowname1')\"/> <small> Height : 50px and Width : 160px</small> </td></tr>\n<tr>\n    <td width=\"200px\" class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn add\" type=\"button\"  \n    onclick=\"SubmitForm ('#btnaddgroup','fieldmanufacture','#frm','#notification','true','#main_loader','main2.php?page=manufacturelist');\"/></td>\n</tr>\n\n</tbody>\n</table>\n\n</form>\n\n\n</div></div>\n \n";
$sql = "SELECT  id, \nCONCAT('<a class=\\'default_dg_a2\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editmanufacture&id=',id,'\\', \\'" . $LNG["edit"] . " " . $LNG["manufacture"] . "\\');    return false;\" >',name,'</a>') as name,\nimage_link,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editmanufacture&id=',id,'\\', \\'" . $LNG["edit"] . " " . $LNG["manufacture"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_manufacture where 1=1 ";
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
$filtering_fields = ["Manufacture" => ["type" => "textbox", "autocomplete" => "false", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_manufacture", "field" => "name", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["name" => ["header" => (string) $LNG["name"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "image_link" => ["header" => (string) $LNG["imagelink"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_manufacture";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (isset($_GET["rid"]) || $p) {
    echo "</div>";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>