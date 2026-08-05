<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

include DATAGRID_DIR . "comm.php";
licince\reqaddon("POS");
$pageid = 488;
checkPagePermission($pageid);
if ($_ff_onSUBMIT_FILTER == "Search" || $Generate_Barcode || $p) {
    if ($pg == "manage2") {
        echo "<ul id=\"tabmenu\"> \n   <li><a \n    onclick=\"getContect('#tab','main2.php?page=pos.products2','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\">";
        echo $LNG["products"];
        echo " ";
        echo $LNG["list"];
        echo "</a></li> \n   <li><a class='tabmenu_active'\n    onclick=\"getContect('#tab1','main2.php?page=pos.barcode&pg=manage2','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\">";
        echo $LNG["generate"];
        echo " ";
        echo $LNG["barcode"];
        echo "</a></li>\n   <li><a \n    onclick=\"getContect('#tab2','main2.php?page=pos.setting','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\">";
        echo $LNG["settings"];
        echo "</a></li> \n <li><a id=\"tab3\">";
        echo $LNG["products"];
        echo "</a>\n        <ul>\n        <li><a class=\"simplelink\" \n        onclick=\"getContect('#tab3','main2.php?page=addproducts','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\"  >";
        echo $LNG["product"];
        echo "</a></li>\n        <li><a class=\"simplelink\" \n        onclick=\"getContect('#tab3','main2.php?page=productgroups','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" >";
        echo $LNG["product"];
        echo " ";
        echo $LNG["group"];
        echo "</a></li>\n        </ul>\n  </li>     \n<div style=\"clear: both;\"></div>\n</ul>\n";
    } else {
        echo "<ul id=\"tabmenu\"> \n    <li><a \n    onclick=\"getContect('#tab','main2.php?page=pos.products','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\">";
        echo $LNG["products"];
        echo "</a></li> \n    <li><a class='tabmenu_active'  \n    onclick=\"getContect('#tab1','main2.php?page=pos.barcode','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\">";
        echo $LNG["generate"];
        echo " ";
        echo $LNG["barcode"];
        echo "</a></li>\n     <li><a \n    onclick=\"getContect('#tab2','main2.php?page=pos.setting','";
        echo $id;
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab2\">";
        echo $LNG["settings"];
        echo "</a></li> \n    <div style=\"clear: both;\"></div>\n</ul>\n";
    }
    echo "<br />\n<div id=\"tabcontent\">\n";
}
if ($Generate_Barcode) {
    $dh = opendir("tmp/");
    while (false !== ($file = readdir($dh))) {
        if ($file != "." && $file != ".." && strpos($file, "barcode.gif")) {
            unlink("tmp/" . $file);
        }
    }
    echo "  <script>\nload_subpage('main2.php?page=pos.generate&ids=";
    echo $rid;
    echo "','";
    echo $LNG["generate"];
    echo " ";
    echo $LNG["barcode"];
    echo "');\n  </script>\n  ";
}
if ($serial) {
    if ($from && $to && $from < $to) {
        if ($to - $from <= 1000) {
            echo "  <script>\nload_subpage('main2.php?page=pos.generateserial&from=";
            echo $from;
            echo "&to=";
            echo $to;
            echo "','";
            echo $LNG["generate"];
            echo " ";
            echo $LNG["barcode"];
            echo "');\n  </script>\n  ";
        } else {
            echo "<div id='notification1' class='errorbox'>Please don't generate more than 1000 barcode. It may hang your system.</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Wrong serial number range</div>";
    }
}
echo "<div id=\"content\">\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n<input type=\"hidden\" name=\"loaddefault\" value=\"pos.barcode.php\" />\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Generate Barcode</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n  \n<table class=\"form\" style=\"width: auto;\">\n<tbody>\n\n\n<tr>\n    <td class=\"fieldlabel\"> ";
echo $LNG["serialno"];
echo "</td>\n    <td class=\"fieldarea\">\n         ";
echo $LNG["from"];
echo " <input type=\"text\" name=\"from\" style=\"width: 100px;\" />\n        &nbsp;";
echo $LNG["to"];
echo " <input type=\"text\" name=\"to\" style=\"width: 100px;\" />     \n   </td>\n   <td><input type=\"submit\" name=\"serial\" value=\"";
echo $LNG["generate"];
echo " ";
echo $LNG["barcode"];
echo "\" /></td>\n</tr>\n\n</tbody>\n</table>\n</div></div>\n</form>\n\n\n\n</div>\n</div>\n";
$sql = "SELECT  tbl_products.id,service_name  AS servicename, \ncredit,time,tbl_products.active,if(tbl_products.active = '1', '" . $img_green . "','" . $img_red . "')  AS flags \nFROM tbl_products left outer join tbl_product_group on group_id=tbl_product_group.id where tbl_product_group.active='1'";
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"], "deleting" => ["view" => true, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false], "generate" => ["view" => true, "flag_name" => "Generate Barcode", "flag_value" => "yes", "tooltip" => "Generate Barcode"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "pg"];
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
$result = dquery("select id,group_name from tbl_product_group where active=1 order by display_order");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_group[$row["id"]] = $row["group_name"];
}
$result = dquery("select id,service_name from tbl_products where \nactive=1 order by service_name asc");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_product[$row["id"]] = $row["service_name"];
}
$filtering_fields = ["Status" => ["type" => "dropdownlist", "table" => "tbl_products", "field" => "active", "field_view" => "active", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Product" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/product.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_products", "field" => "service_name", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Group Name" => ["type" => "dropdownlist", "table" => "tbl_products", "field" => "group_id", "field_view" => "group_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Happy Hours From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_products", "field" => "happy_hours_start", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "Happy Hours To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_products", "field" => "happy_hours_end", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal", "width" => "10px"], "servicename" => ["header" => (string) $LNG["servicename"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "flags" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "credit" => ["header" => (string) $LNG["credit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_products";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $Generate_Barcode || $p) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>