<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 180;
checkPagePermission($pageid);
require ROOTDIR . "/includes/clients.fun.inc.php";
include "includes/3rdparty/editor/editor.php";
echo "\n    <style>\n        .form{margin-bottom: 4px !important;}\n    </style>\n\n";
if ($news && $date) {
    checkDemoMode(false);
    $data["date"] = $date;
    $data["scroll"] = $scroll;
    $data["status"] = 1;
    $data["beforelogin"] = $beforelogin;
    $data["news"] = html_entity_decode($news);
    $data["beforedate"] = $beforedate;
    if ($id = $db->insert("tbl_quick_news", $data)) {
        $sendbr = $broadcast;
        $_SESSION["IDCG"] = $id;
        $_SESSION["MGCG"] = str_replace("&nbsp;", " ", strip_tags(html_entity_decode($news)));
        echo "<div id=notification1 class=successbox>  " . $LNG["savesuccessfully"] . " </div>";
    } else {
        echo "<div id=notification1 class=errorbox> " . $LNG["datanotsave"] . " </div>";
    }
} else {
    if ($save) {
        echo "<div id=notification1 class=errorbox> " . $LNG["fieldblank"] . " </div>";
    }
}
if ($sendbr) {
    checkDemoMode(false);
    $batch = [];
    $u = dquery("select gcmid from tblUsers where gcmid!=''");
    $tot = mysqli_num_rows($u);
    if (!$start) {
        $start = 0;
    }
    $limit = 500;
    $u = dquery("select gcmid from tblUsers where gcmid!=''\n             limit " . $start . "," . $limit);
    while ($r = mysqli_fetch_assoc($u)) {
        $batch[] = $r["gcmid"];
    }
    $message = ["msg" => $_SESSION["MGCG"], "server" => $_SERVER["SERVER_NAME"], "id" => $_SESSION["IDCG"] . "", "title" => $config["companyname"]];
    $url = "https://android.googleapis.com/gcm/send";
    $fields = ["registration_ids" => $batch, "data" => $message];
    $headers = ["Authorization: key=" . $config["googlegcm"], "Content-Type: application/json"];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    if ($result === false) {
        exit("Curl failed: " . curl_error($ch));
    }
    curl_close($ch);
    if ($start + $limit < $tot) {
        $start = $start + $limit;
        echo "<div id='notification1' class='successbox'> Your Batch is in process...\n<a href=\"javascript:reloadcurrent('quicknews','&sendbr=1&start=";
        echo $start;
        echo "&limit=";
        echo $limit;
        echo "')\">Click Here to go to Next Batch</a> </div>\n";
        sleep(10);
        echo "<script>  reloadcurrent('quicknews','&sendbr=1&start='+";
        echo $start;
        echo "); </script>\n";
    }
}
echo "\n\n<div id=\"content\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<div  class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["quick"];
echo " ";
echo $LNG["news"];
echo "</span>\n    &nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n<div class=\"groupstabescontant\">\n\n<table class=\"form\">\n<tbody>\n\n\n\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["news"];
echo "</td>\n    <td class=\"fieldarea\">\n   <textarea name=\"news\"  id=\"message\" style=\"height: 200px !important;\" ></textarea>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" >";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"date\" id=\"from\" class=\"datepicker\" autocomplete=\"off\" placeholder=\"yyyy-mm-dd\" value=\"";
echo date("Y-m-d");
echo "\" />\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\" >Show Till ";
echo $LNG["date"];
echo "</td>\n    <td class=\"fieldarea\"><span>\n    <input type=\"text\" name=\"beforedate\"  class=\"datepicker\"  autocomplete=\"off\" placeholder=\"yyyy-mm-dd\" id=\"to\" value=\"\" />\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["display"];
echo " in Scroll</td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"radio\" value=\"1\" name=\"scroll\"\n    id=\"publi\" /> <label for=\"publi\">";
echo $LNG["yes"];
echo "</label>\n    <input type=\"radio\" value=\"0\" name=\"scroll\" checked=\"checked\"  id=\"unpubli\" />\n    <label for=\"unpubli\">";
echo $LNG["no"];
echo "</label>\n    </span></td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"checkbox\" value=\"1\" name=\"beforelogin\"\n    id=\"beforelogin\" /> <label for=\"beforelogin\">";
echo $LNG["show"];
echo " ";
echo $LNG["before"];
echo " ";
echo $LNG["login"];
echo "</label>\n    </span></td>\n</tr>\n";
if (licince\reqaddon("Custom mobile app", true)) {
    echo "<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><span>\n   <input type=\"checkbox\" value=\"1\" name=\"broadcast\"\n     id=\"broadcast\" /> <label for=\"broadcast\">Broadcast on Android App</label>\n     </span></td>\n</tr>\n";
}
echo "</tbody>\n<tfoot>\n<tr>\n    <td></td>\n    <td><input value=\"";
echo $LNG["publish"];
echo "\" id=\"btnpost\" name=\"save\"\n class=\"btn\" type=\"submit\"  /></td>\n</tr>\n</tfoot>\n</table>\n</div></div>\n\n<p align=\"center\" class=\"fixedbtn\">\n</p>\n</form>\n<br />\n";
include DATAGRID_DIR . "comm.php";
$sql = "SELECT * FROM tbl_quick_news";
if (isset($delete)) {
    dquery("delete from tbl_quick_news where id='" . $id . "'");
}
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => true], "details" => ["view" => false]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage", "year"];
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
if ($config["adminlistlimit"] && !in_array($config["adminlistlimit"], $pages_array)) {
    $pages_array[$config["adminlistlimit"]] = $config["adminlistlimit"];
}
$default_page_size = $config["adminlistlimit"] ? $config["adminlistlimit"] : 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$fill_ebay = ["1" => "Yes", "0" => "No"];
$filtering_fields = ["News" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_quick_news", "field" => "news", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_quick_news", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_quick_news", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["id" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "news" => ["header" => (string) $LNG["news"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action_links" => ["header" => (string) $LNG["edit"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_quick_news";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($action == "refund" && $id) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>