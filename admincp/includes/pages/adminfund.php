<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction blank(id){\n  bl = document.getElementById(id);\n  bl.value = '';\n} </script>\n \n";
if ($_ff_onSUBMIT_FILTER) {
}
$exp = explode(",", $_SESSION["page_access"]);
if (!in_array(55, $exp)) {
    echo "<div id='notification1' class='errorbox'>You are not allowed</div>";
    exit;
}
$page = "adminfund.php";
$val = dquery("select 1 from `tbl_admin_fund_log`");
if ($val === false) {
    dquery("CREATE TABLE IF NOT EXISTS `tbl_admin_fund_log` (  `id` int(11) NOT NULL AUTO_INCREMENT,  `aid` int(11) NOT NULL,  `desc` text NOT NULL,  `date` varchar(50) NOT NULL,  `amount` varchar(20) NOT NULL,  `type` varchar(10) NOT NULL,  PRIMARY KEY (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
}
$admins = mysqli_fetch_assoc(dquery("select * from tbl_admin where id='" . $admn . "'"));
echo "<div title=\"userfinance\" id=\"tutid\"></div> \n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n\n\n\n<div  class=\"groupstabes\">\n          <h2>\n<span class=\"groupstabesheadertext\">Current Fund Limit</span> : <span id=\"fgs\">\n";
if ($admins["credit"] != "") {
    echo formatCurrency($admins["credit"]);
} else {
    echo "Unlimited";
}
echo "</span> \n\n<span style=\"float: right;margin-top:-5px\">\n<form method=\"post\" id=\"frmss\">\n<input type=\"hidden\" name=\"admni\" value=\"";
echo $admn;
echo "\" />\n<input type=\"button\" name=\"clear\" value=\"Set Unlimited\" id=\"bts\"\n onclick=\"SubmitForm ('#bts','editadmin.fund','#frmss','#notification','true','#main_loader');\n \$('#fgs').html('Unlimited');\"\n />\n </form>\n</span> \n          </h2>\n          \n             \n     <form id=\"frmedituser\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"id\" value=\"";
echo $admn;
echo "\"/>     \n          <div class=\"groupstabescontant\">                 \n           \n<div class=\"left\">  \n    <table class=\"form\">\n    \n    <tr>\n        <td class=\"fieldlabel\">Fund Limit</td>\n        <td class=\"fieldarea\">\n            <input type=\"radio\" checked=\"\" onclick=\"\$('.add').show();\$('.rebate').hide();\" name=\"limit\" value=\"1\" /> <label>Add</label>\n            <input type=\"radio\" onclick=\"\$('.add').hide();\$('.rebate').show();\" name=\"limit\" value=\"2\" /> <label>Rebate</label>\n        </td>\n    </tr>\n    \n    <tr class=\"add\"><td class=\"fieldlabel\">   ";
echo $LNG["limit"];
echo "</td>\n        <td class=\"fieldarea\"><input name=\"creditleft\" id=\"creditleft\" value=\"\" \n        type=\"text\" class=\"small_txt addcredit-icon\" onKeyPress=\"blank('rebatecredit')\" \n        onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/></td>\n    </tr>\n\n        <tr class=\"add\"><td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["note"];
echo "</td><td class=\"fieldarea\"><textarea name=\"admin_notea\"></textarea></td></tr>\n       <tr class=\"add\"><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input value=\"";
echo $LNG["add"];
echo "\" id=\"btnedituser\" \n       class=\"btn save\" type=\"button\"  \n       onclick=\"SubmitForm ('#btnedituser','editadmin.fund','#frmedituser','#notification','true','#main_loader');\"/></td></tr>\n       \n       \n<tr class=\"rebate\" style=\"display: none;\"><td class=\"fieldlabel\">   ";
echo $LNG["limit"];
echo "</td>\n<td class=\"fieldarea\"><input name=\"rebatecredit\"  value=\"\" id=\"rebatecredit\" type=\"text\" class=\"small_txt rebatecredit-icon\" onKeyPress=\"blank('creditleft')\" onKeyUp=\"return cF(this,false)\" onBlur=\"return cF(this,true)\"/>\n        </td></tr>\n     \n     \n     <tr  class=\"rebate\"  style=\"display: none;\"><td class=\"fieldlabel\">";
echo $LNG["admin"];
echo " ";
echo $LNG["note"];
echo "</td><td class=\"fieldarea\"><textarea name=\"admin_noter\"></textarea></td></tr>\n<tr  class=\"rebate\"  style=\"display: none;\"><td class=\"fieldlabel\"></td><td class=\"fieldarea\"><input value=\"";
echo $LNG["rebate"];
echo "\" id=\"btnedituser\" class=\"button_remove\"\n type=\"button\"  onclick=\"SubmitForm ('#btnedituser','editadmin.fund','#frmedituser','#notification','true','#main_loader');\"/></td></tr>\n \n       \n    </table>\n</div> \n             \n \n</div>\n</form>\n\n <div class=\"clear\"></div>\n\n<br /><br /><br />\n\n\n\n";
include_once DATAGRID_DIR . "comm.php";
echo "\n";
$sql = "SELECT * from tbl_admin_fund_log where aid='" . $admn . "'\n";
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
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Delete Admin" => ["view" => true, "flag_name" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete Admin"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "admn"];
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
$fill_from_status = ["Active", "Inactive"];
$fill_from_status = ["Add" => "Add", "Rebate" => "Rebate"];
$filtering_fields = ["Type" => ["type" => "dropdownlist", "table" => "tbl_admin_fund_log", "field" => "type", "field_view" => "type", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_admin_fund_log", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_admin_fund_log", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "width" => "80px", "wrap" => "nowrap", "text_length" => "50", "case" => "normal", "width" => "30px"], "desc" => ["header" => (string) $LNG["description"], "type" => "label", "align" => "left", "width" => "400px", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "type" => ["header" => (string) $LNG["type"], "type" => "label", "align" => "right", "width" => "400px", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "amount" => ["header" => $LNG["amount"] . " [" . $_SESSION["system_default_currency"]["code"] . "]", "summarize" => true, "type" => "enum", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_admin";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER) {
    echo " </div>\n ";
}
echo "\n\n\n\n\n\n</div>\n\n\n";
$fileverioncheck = "6.1.0";

?>