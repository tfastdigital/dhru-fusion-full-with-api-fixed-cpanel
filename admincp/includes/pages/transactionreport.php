<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 437;
checkPagePermission($pageid);
echo "    <div id=\"content\" style=\"width: 100%;!important \">\n        <div id=\"content_padded\" style=\"width: 100%;!important \">\n            <form method=\"post\" id=\"frms\">\n                <div style=\"font-size: 12px; float: left;width:49%;\">\n                    ";
$WHERE = "";
if (isset($_POST["_ff_tbl_transaction_date_fo_to"])) {
    $datefrom = $_POST["_ff_tbl_transaction_date_fo_from"];
    $dateto = $_POST["_ff_tbl_transaction_date_fo_to"];
    if ($datefrom && $dateto) {
        $WHERE = " and (`date` between '" . $datefrom . "' and '" . $dateto . "')";
    }
}
$CUR = [];
$c = dquery("select id,code from tbl_currencies ");
while ($rc = mysqli_fetch_assoc($c)) {
    $CUR[$rc["id"]] = $rc["code"];
}
$q = dquery("select id from  tbl_transaction where 1=1 " . $WHERE);
$cnt = mysqli_num_rows($q);
$d = dquery("select (amountin) as amount,(fees) as fee,(select default_currency\nfrom tblUsers where id=userid) as currencyid from tbl_transaction where 1=1 " . $WHERE);
$ARR = [];
while ($r = mysqli_fetch_assoc($d)) {
    if ($r["currencyid"]) {
        $ARR[$r["currencyid"]]["amount"] += $r["amount"];
        $ARR[$r["currencyid"]]["fee"] += $r["fee"];
    }
}
echo "                    <table  >\n                        <tr>\n                            <td class=\"fieldlabel \" style=\"text-align: left\" >\n                                Total Transaction\n                            </td>\n                            <td class=\"fieldlabel \" style=\"text-align: left\" >\n\n                                <strong>";
echo $cnt;
echo "</strong>\n                            </td>\n                        </tr>\n\n                        ";
foreach ($ARR as $currencyid => $detail) {
    echo "                            <tr>\n                                <td class=\"fieldlabel \" style=\"text-align: left\" >\n                                    Amount[";
    echo $CUR[$currencyid];
    echo "]\n                                </td>\n                                <td class=\"fieldlabel \" style=\"text-align: left\" >\n                                    <strong>";
    echo $detail["amount"];
    echo "</strong>\n                                </td>\n                            </tr>\n                            <tr>\n                                <td class=\"fieldlabel \" style=\"text-align: left\" >\n                                    Fee[";
    echo $CUR[$currencyid];
    echo "]\n                                </td>\n                                <td class=\"fieldlabel \" style=\"text-align: left\" >\n                                    <strong>";
    echo $detail["fee"];
    echo "</strong>\n                                </td>\n                            </tr>\n                            ";
}
echo "                        </td>\n                        </tr>\n                    </table>\n                </div>\n            </form>\n        </div>\n    </div>\n    <br/><br/><br/>\n";
include DATAGRID_DIR . "comm.php";
$sql = "SELECT\nconcat('<a class=\"default_dg_a\" href=\"javascript:load_fromsubpage(\\'edituser&id=',userid,'\\',\\'',(select username from tblUsers where id=userid),'\\')\">',(select username from tblUsers where id=userid),'</a>') as  user\n,date,transid,\n concat('<a href=\"javascript: load_subpage(\\'main2.php?page=edituser.editinvoice&processorder=true&invoiceid=',invoiceid,'&id=',invoiceid,'\\',\\'View invoice\\')\">',(SELECT IF(status='Unpaid',concat('P/',mask),concat('I/',mask)) as ins from tbl_invoices where tbl_invoices.id=invoiceid ),'</a>') as  invoiceid\n,description,\nconcat(amountin,' ',(select code from tbl_currencies where id=(select default_currency from tblUsers where id=userid))) as amount, \nconcat(fees,' ',(select code from tbl_currencies where id=(select default_currency from tblUsers where id=userid))) as fees,\n(select value from tbl_paymentgateways where setting='name' and tbl_paymentgateways.gateway=tbl_transaction.gateway) as gateway\nFROM tbl_transaction WHERE 1=1";
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
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => false, "type" => "image"]];
$dgrid->SetModes($modes);
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => false]];
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
$filtergateway = [];
$qg = dquery("select gateway,value from tbl_paymentgateways where setting='name'");
while ($rg = mysqli_fetch_assoc($qg)) {
    $filtergateway[$rg["gateway"]] = $rg["value"];
}
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_admin = $admin;
$fill_from_discription = $discription;
$filtering_fields = ["From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_transaction", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_transaction", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "Transaction ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_transaction", "field" => "transid", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Client" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_transaction", "field" => "userid", "subquery" => "(SELECT username FROM tblUsers WHERE id = userid)", "show_operator" => "false", "default_operator" => "subquery", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Gateway" => ["type" => "dropdownlist", "table" => "tbl_transaction", "field" => "gateway", "field_view" => "gateway", "filter_condition" => "", "order" => "ASC", "source" => $filtergateway, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "invoiceid" => ["header" => (string) $LNG["invoice"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gateway" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "amount" => ["header" => (string) $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "fees" => ["header" => (string) $LNG["fees"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "transid" => ["header" => (string) $LNG["transaction"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_transaction";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>