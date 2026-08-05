<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($p) {
    echo "    <ul id=\"tabmenu\">\n        <li><a ";
    if (!$laoddefaultpage) {
        echo " class=\"tabmenu_active\" ";
    }
    echo " onclick=\"getContect('#tab2','main2.php?page=softwarekey.list','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li>\n        <li><a  onclick=\"getContect('#tab1','main2.php?page=softwarekey','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" > + ";
    echo $LNG["create"];
    echo " ";
    echo $LNG["reply"];
    echo "</a></li>\n        <li><a  ";
    if ($laoddefaultpage == "softwarekeygroup.php") {
        echo " class=\"tabmenu_active\" ";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=softwarekeygroup','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >  ";
    echo $LNG["auto"];
    echo " ";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["group"];
    echo "</a></li>\n        <div style=\"clear: both;\"></div>\n    </ul>\n    <div id=\"tabcontent\">\n    ";
}
$pageid = 439;
checkPagePermission($pageid);
echo "        <script>\n            function loadStock(gropuid){\n                location.href='main2.php?page=softwarekeymain&laoddefaultpage=softwarekey.list.php&selectedgroup='+gropuid;\n            }\n        </script>\n    <select name=\"stockgroup\" onchange=\"javascript: loadStock(this.value);\" >\n        <option value=\"\">-Select Group-</option>\n        ";
$qs = dquery("select id,`group` from tbl_keygroup");
while ($r = mysqli_fetch_assoc($qs)) {
    $selected = "";
    if ($r["id"] == $selectedgroup) {
        $selected = "selected";
    }
    echo "            <option ";
    echo $selected;
    echo " value=\"";
    echo $r["id"];
    echo "\">";
    echo $r["group"];
    echo "</option>\n        ";
}
echo "    </select>\n";
if ($mode == "aedit" && $rid) {
    $rid = explode("-", $rid);
    foreach ($rid as $rd) {
        dquery("UPDATE tbl_swkey set status=1 where id='" . $rd . "'");
    }
}
if ($mode == "eedit" && $rid) {
    $rid = explode("-", $rid);
    foreach ($rid as $rd) {
        dquery("UPDATE tbl_swkey set status=0 where id='" . $rd . "'");
    }
}
if ($mode == "ddelete" && $rid) {
    $rid = explode("-", $rid);
    foreach ($rid as $rd) {
        dquery("DELETE FROM tbl_swkey where id='" . $rd . "'");
    }
}
include DATAGRID_DIR . "comm.php";
$wheres = "";
if ($filter) {
    $wheres = " and group_id='" . $filter . "'";
    if ($stock) {
        $wheres .= " and used=0";
    } else {
        $wheres .= " and used=1";
    }
}
if ($selectedgroup) {
    $wheres .= " and group_id='" . $selectedgroup . "' and qnt>used";
    $sql = "SELECT  tbl_swkey.addedon,IF(tbl_swkey.qnt=0,'1',tbl_swkey.qnt) as qnt,purchase,tbl_swkey.id,CONCAT('<a href=\\'javascript: void(0)\\' \n    onclick=\\'load_subpage(\"main2.php?page=editkey&id=',tbl_swkey.id,'\", \n    \"" . $LNG["edit"] . "\"); \n    return false;\\'>',tbl_swkey.key,'</a>')  AS `skey`,\n    (select username from tblUsers where id=uid) as user,\n    CONCAT('<a href=\\'javascript: void(0)\\' class=\\'editdata\\'\n    onclick=\\'load_subpage(\"main2.php?page=editkey&id=',tbl_swkey.id,'\", \n      \"" . $LNG["edit"] . "\"); \n    return false;\\'>" . $LNG["edit"] . "</a>')  AS `action`, \n    date,IF(expiredon='','-',expiredon) as expiredon,(SELECT `group` from tbl_keygroup where id=tbl_swkey.group_id) \n    as `groups`,if(tbl_swkey.status = '1', '" . $LNG["used"] . "','" . $LNG["unused"] . "')  \n    AS flags, (select  sum(qnt) from tbl_used_key \n    where keyid=tbl_swkey.id) as  usedstock\n    ,(select group_concat(orderid)   from tbl_used_key  \n    where keyid=tbl_swkey.id) as orders\n    FROM tbl_swkey where 1=1 " . $wheres;
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
    $modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => false, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => false, "type" => "image"]];
    $dgrid->SetModes($modes);
    $multirow_option = true;
    $dgrid->AllowMultirowOperations($multirow_option);
    $multirow_operations = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "aedit" => ["view" => true, "edit" => false, "flag_name" => "markused", "flag_value" => "markused", "tooltip" => "Mark as Used"], "eedit" => ["view" => true, "edit" => false, "flag_name" => "markunused", "flag_value" => "markunused", "tooltip" => "Mark as Pending"], "ddelete" => ["view" => true, "edit" => false, "flag_name" => "ddelete", "flag_value" => "ddelete", "tooltip" => "Delete"]];
    $dgrid->SetMultirowOperations($multirow_operations);
    $http_get_vars = ["page", "accesskey", "laoddefaultpage", "display_errors", "id", "selectedgroup"];
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
    $fill_from_status = ["1" => "Used", "0" => "Pending"];
    $fill_from_group = NULL;
    $sql = dquery("select * from tbl_keygroup");
    while ($row = mysqli_fetch_assoc($sql)) {
        $fill_from_group[$row["id"]] = $row["group"];
    }
    $filtering_fields = ["Group" => ["type" => "dropdownlist", "table" => "tbl_swkey", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_swkey", "field" => "status", "field_view" => "status", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_swkey", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_swkey", "field" => "expiredon", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
    $dgrid->SetFieldsFiltering($filtering_fields);
    $vm_table_properties = ["width" => "100%"];
    $dgrid->SetViewModeTableProperties($vm_table_properties);
    $vm_colimns = ["skey" => ["header" => $LNG["software"] . " " . $LNG["key"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "purchase" => ["header" => (string) $LNG["purchase"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "date" => ["header" => $LNG["used"] . " " . $LNG["on"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "addedon" => ["header" => "Added On", "type" => "label", "align" => "left", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""], "expiredon" => ["header" => (string) $LNG["expired"], "type" => "label", "align" => "left", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""], "qnt" => ["header" => $LNG["available"] . " " . $LNG["stock"], "type" => "label", "align" => "left", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""], "usedstock" => ["header" => $LNG["used"] . " " . $LNG["stock"], "type" => "label", "align" => "left", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""], "orders" => ["header" => (string) $LNG["order"], "type" => "label", "align" => "left", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
    $dgrid->SetColumnsInViewMode($vm_colimns);
    $em_table_properties = ["width" => "75%"];
    $dgrid->SetEditModeTableProperties($em_table_properties);
    $dm_table_properties = ["width" => "60%"];
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
    $table_name = "tbl_swkey";
    $primary_key = "id";
    $condition = "";
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
    $dgrid->WriteCssClass();
    $dgrid->Bind();
    if ($p) {
        echo "    </div>\n";
    }
}
$fileverioncheck = "6.1.0";

?>