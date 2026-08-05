<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
if ($id && ($_REQUEST["_ff_onSUBMIT_FILTER"] == "Search" || $cur)) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\">";
}
echo "\n";
if ($id) {
    echo "    <select name=\"currency\" onchange=\"javascript: location.href='main2.php?page=fundtransferreport&id=";
    echo $id;
    echo "&cur='+this.value\">\n        ";
    $s = dquery("select id,code from tbl_currencies order by `default` desc");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "            <option ";
        if ($cur != "" && $cur == $r["id"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["code"];
        echo "</option>\n            ";
    }
    echo "    </select>\n";
} else {
    echo "    <select name=\"currency\" onchange=\"javascript: location.href='main2.php?page=fundtransferreport&cur='+this.value\">\n        ";
    $s = dquery("select id,code from tbl_currencies order by `default` desc");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "            <option ";
        if ($cur != "" && $cur == $r["id"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $r["id"];
        echo "\">";
        echo $r["code"];
        echo "</option>\n            ";
    }
    echo "    </select>\n";
}
echo "\n\n    <style>\n        td.default_dg_td  .dg_right{\n            text-align: left !important;\n        }\n        th.dg_right {\n            font-size: 14px !important;\n            font-weight:bold !important;\n        }\n    </style>\n";
$pageid = 492;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
if ($cur) {
    $linked = $cur;
} else {
    $sq = mysqli_fetch_assoc(dquery("select id from tbl_currencies\n     where `default`='1'"));
    $linked = $sq["id"];
}
$code = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $linked . "'"));
$WHERE = "";
if ($uid) {
    $WHERE = " and uid='" . $uid . "'";
}
$sql = "select *,amount as amt\n,CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',uid,'\\',\\' ',(select username from tblUsers where id=uid),'\\')\">',(select username from tblUsers where id=uid),'</a>' )   \n as user\n,CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',tbl_statement_user.uid,'\\',\\' ',(select username from tblUsers where id=uid),'\\')\">',description,'</a>' )   \n as descr from tbl_statement_user where stype like '%Transfer%' " . $WHERE . " \n";
$laoddefaultpage = $page;
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$dgrid->safeMode = false;
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "uid", "pass", "id", "cur", "linked"];
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
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`username` FROM `tblUsers`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $user[$rows["id"]] = $rows["username"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_admin`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $admin[$rows["id"]] = $rows["username"];
}
$descr = ["+ Add Fund" => "Add Fund", "New Order Placed" => "New Order Placed", "Order Set back to Rejected" => "Order Set back to Rejected", "Credit Apply to Invoice" => "Credit Apply to Invoice", "Credit Transfer" => "Credit Transfer", "Reseller Store Commision" => "Reseller Store Commision"];
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_type = ["DR" => "DR", "CR" => "CR"];
$filtering_fields = ["User" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "uid", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $user, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Type" => ["type" => "dropdownlist", "table" => "tbl_statement_user", "field" => "type", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_statement_user", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "descr" => ["header" => (string) $LNG["description"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "amt" => ["header" => $LNG["amount"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => true], "transferfee" => ["header" => $LNG["fee"] . " [" . $code["code"] . "]", "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal", "summarize" => true], "rel" => ["header" => "RELID", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "admin" => ["header" => (string) $LNG["admin"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "right", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_statement_user";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";
if ($_REQUEST["_ff_onSUBMIT_FILTER"] == "Search") {
    echo "</div>";
}
echo "\n";

?>