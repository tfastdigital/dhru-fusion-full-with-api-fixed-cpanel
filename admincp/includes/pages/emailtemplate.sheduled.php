<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 535;
checkPagePermission($pageid);
if ($_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    echo "    <ul id=\"tabmenu\">\n        <li><a  onclick=\"getContect('#tab2','main2.php?page=mailsettings.basic','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["basic"] . " " . $LNG["mailsettings"];
    echo "</a></li>\n        <li><a  onclick=\"getContect('#tab','main2.php?page=emailtemplate.list','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["emailtemplate"];
    echo "</a></li>\n        <li><a  href=\"main2.php?page=mailsetting&laoddefaultpage=emailtemplate.add.php\" id=\"tab1\" > ";
    echo $LNG["addemailtemplate"];
    echo " </a></li>\n        <li><a onclick=\"getContect('#tab3','main2.php?page=emailtemplate.notification','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["system"];
    echo " ";
    echo $LNG["notification"];
    echo "</a></li>\n        <li><a class='tabmenu_active'  onclick=\"getContect('#tab4','main2.php?page=emailtemplate.sheduled','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["sheduled"];
    echo " ";
    echo $LNG["mail"];
    echo "</a></li>\n    <div style=\"clear: both;\"></div>\n    </ul>\n";
}
echo "<div><div title=\"clientlist\" id=\"tutid\"></div>\n";
include_once DATAGRID_DIR . "comm.php";
include_once "includes/comm.inc.php";
include_once ROOTDIR . "/includes/mail.fun.php";
if ($send && $id) {
    $ui = mysqli_fetch_assoc(dquery("select userid from tbl_sheduledmail\n     where id='" . $id . "'"));
    if (sendMail(999, $ui["userid"], "", "", "", "", "", "", "", "", "", "", "", $id)) {
    }
    echo "<div id='notification1' class='successbox'>Mail Send successfully</div>";
}
if ($cancel && $id) {
    dquery("DELETE FROM tbl_sheduledmail WHERE id='" . $id . "'");
    echo "<div id='notification1' class='successbox'>Mail cancel successfully</div>";
}
$ffk = 0;
$ind = dquery("SHOW INDEX FROM tbl_sheduledmail");
while ($r = mysqli_fetch_assoc($ind)) {
    if ($r["Key_name"] == "userid") {
        $ffk = 1;
    }
}
if ($ffk == 0) {
    dquery("ALTER TABLE `tbl_sheduledmail` ADD INDEX(`userid`)");
}
if ($mode == "Send Mail") {
    $e = explode("-", $rid);
    foreach ($e as $i) {
        $ui = mysqli_fetch_assoc(dquery("select userid from tbl_sheduledmail where id='" . $i . "'"));
        if (sendMail(999, $ui["userid"], "", "", "", "", "", "", "", "", "", "", "", $i)) {
        }
    }
    echo "<div id='notification1' class='successbox'>Mail Send successfully</div>";
}
if ($mode == "Cancel") {
    $e = explode("-", $rid);
    foreach ($e as $i) {
        dquery("DELETE FROM tbl_sheduledmail WHERE id='" . $i . "'");
    }
    echo "<div id='notification1' class='successbox'>Mail cancel successfully</div>";
}
$sql = "SELECT\n*,(select username from tblUsers where id=userid) as user,\n(select email from tblUsers where id=userid) as email,\nCONCAT('<a class=\\'default_dg_a2\\' \nhref=\"javascript:reloadcurrent(\\'mailsetting&laoddefaultpage=emailtemplate.sheduled.php&send=true\\', ',tbl_sheduledmail.id, ')\">" . $LNG["send"] . "</a> | <a class=\\'default_dg_a2\\' \nhref=\"javascript:reloadcurrent(\\'mailsetting&laoddefaultpage=emailtemplate.sheduled.php&cancel=true\\', ',tbl_sheduledmail.id, ')\">" . $LNG["cancel"] . "</a>'\n) as action_links\nFROM tbl_sheduledmail where 1=1";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "priority";
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Send Mail" => ["view" => true, "flag_name" => "Send Mail", "flag_value" => "yes", "tooltip" => "Send Mail"], "Cancel" => ["view" => true, "flag_name" => "Cancel", "flag_value" => "yes", "tooltip" => "Cancel"]];
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
$default_page_size = 50;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$q = dquery("select username,id from tblUsers");
while ($r = mysqli_fetch_assoc($q)) {
    if (mysqli_num_rows(dquery("select id from tbl_sheduledmail\n        where userid='" . $r["id"] . "'"))) {
        $users[$r["id"]] = $r["username"];
    }
}
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$filtering_fields = ["User" => ["type" => "dropdownlist", "table" => "tbl_sheduledmail", "field" => "userid", "field_view" => "userid", "filter_condition" => "", "order" => "ASC", "source" => $users, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "subject" => ["header" => (string) $LNG["subject"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_sheduledmail";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
echo "</div>";
$fileverioncheck = "6.1.0";

?>