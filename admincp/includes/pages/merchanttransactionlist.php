<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 84;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
$WHERE = " and ( (status!='paid' and   amount>0) or status='paid') ";
if ($view == "unpaid") {
    $WHERE = " and status!='paid' and customid>0 and amount>0";
} else {
    if ($view == "paid") {
        $WHERE = " and status='paid'";
    }
}
if ($_ff_onSUBMIT_FILTER == "Search" && $_ff_tblWalletTransaction_data) {
    $WHERE .= " and \n        transid in (select relid from tbl_statement_user where md5(id)='" . $_ff_tblWalletTransaction_data . "')\n        or refid like '%" . $_ff_tblWalletTransaction_data . "%'\n        or transactionid like '%" . $_ff_tblWalletTransaction_data . "%'";
    unset($_GET["_ff_onSUBMIT_FILTER"]);
    unset($_REQUEST["_ff_onSUBMIT_FILTER"]);
}
$sql = "select  *,CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_subpage(\\'main2.php?page=merchantorderdetail&id=',transid,'\\',\\'Merchant Order Detail\\')\">B_',transid,'</a>' )  AS tid  ,(select tbl_statement_user.amount from tbl_statement_user where stype='Transfer' and relid=transid limit 1) as samount,from_unixtime(`time`,'%h:%i %p') as times,(select `value` from tbl_paymentgateways where setting='name'and tblWalletTransaction.gateway=tbl_paymentgateways.gateway) as gat,(select username from tblUsers where id=merchantid) as merchant,(select email from tblUsers where id=userid) as payer from tblWalletTransaction WHERE 1=1 " . $WHERE;
if ($view == "paid") {
    $WHERES = $WHERE;
    $Date = " Till Today";
    if ($_ff_onSUBMIT_FILTER) {
        $WHERES = " and status='paid' and (date between '" . $_ff_tblWalletTransaction_date_fo_from . "' and '" . $_ff_tblWalletTransaction_date_fo_to . "') ";
        $Date = " " . $_ff_tblWalletTransaction_date_fo_from . " - " . $_ff_tblWalletTransaction_date_fo_to;
    }
    echo "    <table border=\"0\" cellpadding=\"3\" cellspacing=\"2\" style=\"width: 400px !important;\" id=\"main_tbl\">\n\n        ";
    $cq = dquery("select id,code from tbl_currencies");
    while ($rc = mysqli_fetch_assoc($cq)) {
        $trans = mysqli_fetch_assoc(dquery("select sum(amount) as total,sum(fee) as totalfee\n    from tblWalletTransaction where 1=1 " . $WHERES . "\n    and merchantid in (select id from tblUsers where default_currency='" . $rc["id"] . "')"));
        $Total = mysqli_fetch_assoc(dquery("SELECT sum(amount) as total FROM\n `tbl_statement_user` WHERE relid in\n (select transid  from tblWalletTransaction where 1=1 " . $WHERES . "\n    and merchantid in (select id from tblUsers where default_currency='" . $rc["id"] . "') ) and `type`='CR'"));
        if (0 < $trans["total"] || 0 < $trans["totalfee"]) {
            echo "\n                <tr>\n                    <td class=\"fieldlabel\"><strong>Fee (";
            echo $Date;
            echo ")</strong></td>\n                    <td class=\"fieldarea\"><strong>";
            echo $trans["totalfee"];
            echo " [";
            echo $rc["code"];
            echo "]</strong></td>\n                </tr>\n                <tr>\n                    <td class=\"fieldlabel\"><strong>Paid Amount (";
            echo $Date;
            echo ")</strong></td>\n                    <td class=\"fieldarea\"><strong>";
            echo $Total["total"];
            echo " [";
            echo $rc["code"];
            echo "]</strong></td>\n                </tr>\n                ";
        }
    }
    echo "    </table>\n\n    ";
}
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "transid";
$default_order_type = "DESC";
$dgrid->DataSource($db_conn, $sql, $default_order_field, $default_order_type);
$ajax_option = true;
$dgrid->AllowAjax($ajax_option);
$layouts = ["edit" => "0", "details" => "0", "filter" => "1"];
$dgrid->SetLayouts($layouts);
$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];
$dgrid->SetModes($modes);
$dgrid->safeMode = false;
$multirow_option = false;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Export IMEI" => ["view" => true, "flag_name" => "exportimei", "flag_value" => "yes", "tooltip" => "Export IMEI"]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "view", "accesskey", "view", "display_errors", "pass", "id", "laoddefaultpage", "year", "stype"];
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
if (!count($fill_from_api)) {
    $fill_from_api[1] = "";
}
$fill_ebay = ["1" => "Yes", "0" => "No"];
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tblWalletTransaction", "field" => "transid", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Transaction ID" => ["type" => "text", "maxresults" => "10", "shownoresults" => "false", "table" => "tblWalletTransaction", "field" => "data", "show_operator" => "false", "default_operator" => "in", "case_sensitive" => "false", "comparison_type" => "string", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tblWalletTransaction", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tblWalletTransaction", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
if ($view == "paid") {
    $vm_colimns = ["tid" => ["header" => $LNG["order"] . " " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "times" => ["header" => $LNG["time"] . " ", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gat" => ["header" => (string) $LNG["payment"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "transactionid" => ["header" => $LNG["gateway"] . " " . $LNG["invoicestransid"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "50", "case" => "normal"], "samount" => ["header" => (string) $LNG["total"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "50", "case" => "normal"], "merchant" => ["header" => (string) $LNG["merchant"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "payer" => ["header" => (string) $LNG["payer"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
} else {
    $vm_colimns = ["tid" => ["header" => $LNG["order"] . "  " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "times" => ["header" => $LNG["time"] . " ", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gat" => ["header" => (string) $LNG["payment"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "merchant" => ["header" => (string) $LNG["merchant"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "payer" => ["header" => (string) $LNG["payer"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"]];
}
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tblWalletTransaction";
$primary_key = "transid";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($action == "refund" && $id) {
    echo "</div>";
}
echo "\n\n";
$fileverioncheck = "6.1.0";

?>