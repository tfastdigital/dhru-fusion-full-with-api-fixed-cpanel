<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\"><div title=\"clientlist\" id=\"tutid\"></div>\n";
include "client.head.php";
$pageid = 255;
checkPagePermission($pageid);
if ($id) {
    if ($id == "active") {
        $where = "where userstatus=0 and guest=0";
    } else {
        if ($id == "inactive") {
            $where = "where (userstatus=1 or userstatus=2) and guest=0";
        }
    }
} else {
    $where = "where  guest=0";
}
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
if ($mode == "Active") {
    $e = explode("-", $rid);
    foreach ($e as $d) {
        dquery("update tblUsers set userstatus='0' WHERE id='" . $d . "'");
    }
    echo "<div class='successbox' id='notification1'>Account activated successfully </div>";
}
if ($mode == "Inactive") {
    $e = explode("-", $rid);
    foreach ($e as $d) {
        dquery("update tblUsers set userstatus='1' WHERE id='" . $d . "'");
    }
    echo "<div class='successbox' id='notification1'>Account inactivated successfully </div>";
}
$sql = "SELECT\ntblUsers.id,  \nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'pos.edituser&id=',tblUsers.id,'\\',\\' ',tblUsers.username,'\\')\">',username,'</a>' )  AS username,  \nCONCAT( '<a class=\\'default_dg_a\\' href=\"mailto:',tblUsers.email,'\">',tblUsers.email,'</a>' )  AS email,\nCONCAT(IF(tblUsers.credit_left < 100,CONCAT('<span class=textred>',round(tblUsers.credit_left,2),'</span>'),CONCAT('<span>',round(tblUsers.credit_left,2),'</span>')),' ',(select code from tbl_currencies where tbl_currencies.id=tblUsers.default_currency)) as credit_left, \ntblUsers.credit_used,\ntblUsers.userstatus,\nCONCAT(if( tblUsers.userstatus = '0', '<img src=\"images/green.gif\" title=\"Account is fully Activeted\">',if(tblUsers.userstatus = '2' and tblUsers.is_registered = '0','<img src=\"images/blue.gif\" title=\"New register Users\">','<img src=\"images/red.gif\" title=\"Account is inactive for some reason or blocked\">')) ,'&nbsp;&nbsp;', if( tblUsers.usertype = '0', '" . $img_trans . "',if(tblUsers.usertype = '1','<img src=\"images/black.gif\" title=\"Advance Reseller\">','<img src=\"images/gray.gif\" title=\"Resellers Users\">')) ,'&nbsp;&nbsp;', if(DATEDIFF(CURDATE(),FROM_UNIXTIME(last_login)) > 30,'<img src=\"images/yellow.gif\" title=\"Not Login Since Last 30 Days\">','" . $img_trans . "')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'pos.edituser&id=',tblUsers.id,'\\',\\'  ',tblUsers.username,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tblUsers " . $where;
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Active" => ["view" => true, "flag_name" => "Active", "flag_value" => "yes", "tooltip" => "Active"], "Inactive" => ["view" => true, "flag_name" => "Inactive", "flag_value" => "yes", "tooltip" => "Inactive"]];
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
$cl = dquery("select * from tbl_client_group");
while ($rd = mysqli_fetch_assoc($cl)) {
    $fill_from_group[$rd["id"]] = $rd["groupname"];
}
include_once ROOTDIR . "/includes/countries.php";
$filter_country = $countries;
$overd = ["1" => "Overdrive"];
$fill_signup = ["" => "Normal signup", "quick" => "Quick Checkout", "direct" => "Direct Order"];
$filtering_fields = ["Name" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "userstatus", "field_view" => "userstatus", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Overdrive" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "allowoverdrive", "field_view" => "allowoverdrive", "filter_condition" => "", "order" => "ASC", "source" => $overd, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Country" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "country", "field_view" => "country", "filter_condition" => "", "order" => "ASC", "source" => $filter_country, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Client Group" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "client_group", "field_view" => "client_group", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Singup From" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "signupby", "field_view" => "signupby", "filter_condition" => "", "order" => "ASC", "source" => $fill_signup, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "User Type" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "usertype", "field_view" => "usertype", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_user_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Reseller" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "reseller_id", "field_view" => "reseller_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_reseller, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Currency" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "default_currency", "field_view" => "default_currency", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_currency, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal", "width" => "10px"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "credit_left" => ["header" => (string) $LNG["creditleft"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
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
$flags["green"] = $LNG["accountisfullyactiveted"];
$flags["red"] = $LNG["accountisinactive"];
$flags["blue"] = $LNG["newregisteruser"];
$flags["black"] = $LNG["advance"] . " " . $LNG["reseller"];
$flags["gray"] = $LNG["resellersusers"];
$flags["yellow"] = $LNG["notloginsincelastmonth"];
echo "</div>";
$fileverioncheck = "6.1.0";

?>