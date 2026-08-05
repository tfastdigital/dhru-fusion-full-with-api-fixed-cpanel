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
    echo "<ul id=\"tabmenu\">\n    <li><a ";
    if (!$defaultloadpage) {
        echo " class='tabmenu_active' ";
    }
    echo " onclick=\"getContect('#tab','main2.php?page=support.department','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["support"];
    echo " / ";
    echo $LNG["livehelp"];
    echo " ";
    echo $LNG["department"];
    echo "</a></li>\n    <li><a ";
    if ($defaultloadpage == "support.status.php") {
        echo " class='tabmenu_active' ";
    }
    echo "   onclick=\"getContect('#tab1','main2.php?page=support.status','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["ticket"] . " " . $LNG["status"];
    echo "</a></li>\n    <li><a ";
    if ($defaultloadpage == "support.priority.php") {
        echo " class='tabmenu_active' ";
    }
    echo "  onclick=\"getContect('#tab2','main2.php?page=support.priority','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["ticket"] . " " . $LNG["priority"];
    echo "</a></li>\n    <li><a ";
    if ($page == "support.tag") {
        echo "class='tabmenu_active'";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=support.tag','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["taggenerator"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n<div id=\"tabcontent\">\n";
}
$pageid = 433;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if (isset($_GET["rid"])) {
    echo "<div id='tabcontent'>";
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_support_department WHERE id='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
echo "<script language=\"JavaScript\">\nfunction newWindow(file,window)\n{   msgWindow=open(file,window,'scrollbars=yes,resizable=no,width=550,height=400');\n    if (msgWindow.opener == null) msgWindow.opener = self;\n}\n</script>\n<div id=\"notification\"></div>\n\n<div id=\"notification1\" class=\"info\" style=\"position: relative;width:80%;display:block;\" >\n";
echo $LNG["departmentinfo"];
echo "<div style=\"padding: 5px; border: #B5D3FF 1px dashed; margin:10px\"> | php -q ";
echo ROOTDIR;
echo "/includes/pipe.php</div>\nTo enable POP import features to run, make sure you set up a cron job to run Every 5 minute .\nCreate the following Cron Job using PHP\n | <a target=\"_blank\" href=\"https://support.dhru.com/Dhru-Fusion/article/API-/?aid=44&cid=7&pid=1\">How to setup a Cron job in cPanel</a>\n<br />\n<div style=\"padding: 5px; border: #B5D3FF 1px dashed; margin:10px\">\n/usr/bin/wget -O - -q -t 1 ";
echo $config["site_address"];
echo "includes/pop.php</div>\n</div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">Help Department</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["department"];
echo " </td>\n    <td class=\"fieldarea\"><input type=\"text\" class=\"txt medium\" name=\"department\" /></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["email"];
echo "  </td>\n    <td class=\"fieldarea\"><input type=\"text\" class=\"txt medium\" name=\"email\" />  </td>\n</tr>\n<tr>\n<td class=\"fieldlabel\">";
echo $LNG["iconlink"];
echo "</td>\n<td class=\"fieldarea\"> <input type=\"text\" class=\"txt large\" name=\"iconlink\" id=\"iconlink\"\n/> <input type=\"button\" class=\"addFromgallery\" value=\"";
echo $LNG["addgallery"];
echo "\" name=\"upload\" onClick=\"newWindow('includes/gallery.php?id=iconlink', 'windowname1')\" />\n </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["description"];
echo "  </td>\n    <td class=\"fieldarea\"><textarea name=\"info\" class=\"textarea large\"></textarea> </td>\n</tr>\n\n\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"help\" value=\"1\" id=\"eh\" /> <label for=\"eh\">";
echo $LNG["livehelp"];
echo "  <small>";
echo $LNG["this"];
echo " ";
echo $LNG["department"];
echo " ";
echo $LNG["as"];
echo " ";
echo $LNG["livehelp"];
echo "</small>  </label> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"login\" value=\"1\" id=\"el\" /> <label for=\"el\">";
echo $LNG["onlyregistred"];
echo "</label> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" name=\"status\" value=\"1\" id=\"es\" /> <label for=\"es\">";
echo $LNG["show"];
echo " ";
echo $LNG["department"];
echo "</label> </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input type=\"checkbox\" checked=\"checked\" name=\"all\" value=\"1\" id=\"ea\" /> <label for=\"ea\">";
echo $LNG["alocatetoalladmin"];
echo "</label> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">  </td>\n    <td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["department"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','support.department','#frm','#notification','true','#main_loader');\"/></td>\n</tr>\n</tbody>\n</table>\n</div></div>\n</form>\n\n\n</div></div>\n\n";
$sql = "SELECT  tbl_support_department.id, \nCONCAT('<a class=\\'default_dg_a2\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editdepartment&id=',tbl_support_department.id,'\\', \\'" . $LNG["edit"] . "\\');    return false;\" >',department,'</a>') as department,\nemail,\nIF(login=1,'Required','Not Required') as login\n,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editdepartment&id=',tbl_support_department.id,'\\', \\'" . $LNG["edit"] . "\\');    return false;\" >" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_support_department where 1=1 ";
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
$fill_from_status = ["1" => "Login Required", "0" => "Without Login"];
$filtering_fields = ["department" => ["type" => "textbox", "autocomplete" => "false", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_support_department", "field" => "department", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "login" => ["type" => "dropdownlist", "table" => "tbl_support_department", "field" => "login", "field_view" => "login", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["department" => ["header" => (string) $LNG["department"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "login" => ["header" => (string) $LNG["login"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_support_department";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if (isset($_GET["rid"])) {
    echo "</div>";
}
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Support/?aid=37&pid=1&cid=5#ticketlive-help-settings\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
if ($_ff_onSUBMIT_FILTER || $p) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>