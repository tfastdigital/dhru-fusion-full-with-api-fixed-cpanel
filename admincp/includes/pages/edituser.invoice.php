<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_ff_onSUBMIT_FILTER == "Search" && !$byadmin && !$byuser) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
if ($proforma) {
    if (!$byadmin && !$byuser) {
        $byadmin = 1;
    }
    echo "    <script>\n        function filterby(filter)\n        {\n            var filterq='byadmin=1';\n            if(filter=='byuser'){\n                filterq='byuser=1';\n            }\n            location.href='main2.php?page=edituser&laoddefaultpage=edituser.invoice.php&id=";
    echo $id;
    echo "&proforma=1&'+filterq;\n        }\n    </script>\n<div>\n\n    <ul id=\"tabmenu\" class=\"subtab\">\n        <li><a ";
    if (!$byuser) {
        echo "class='tabmenu_active1'";
    }
    echo " onclick=\"filterby('byadmin')\" >By Admin</a></li>\n        <li><a ";
    if ($byuser) {
        echo "class='tabmenu_active1'";
    }
    echo "  onclick=\"filterby('byuser')\" >By User</a></li>\n        <div style=\"clear: both;\"></div>\n    </ul>\n    ";
}
$pageid = 128;
checkPagePermission($pageid);
require ROOTDIR . "/includes/invoice.fun.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($deleteinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("DELETE FROM tbl_invoices WHERE id='" . $val . "'");
        dquery("DELETE FROM tbl_invoiceitems WHERE invocieid='" . $val . "'");
    }
    $success = "Invoice Removed successfully";
}
if ($rebateinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        $inv = mysqli_fetch_assoc(dquery("select userid,total,mask,id from tbl_invoices\nwhere id='" . $val . "'"));
        $admin_noter = "For Invoice P/" . $inv["mask"] . " Ref #" . $val;
        if (rebateCredit($inv["userid"], $inv["total"], 1, "", $admin_noter, $user_noter, $val)) {
            dquery("update tbl_invoices set status='Cancel' where id=" . $val);
        }
    }
    $success = "Invoice cancelled and amount rebated successfully";
}
if ($merge) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    if (1 < count($ids)) {
        $chk = $ids[0];
        $ids[0] = NULL;
        foreach ($ids as $val) {
            if ($val) {
                dquery("UPDATE tbl_invoiceitems SET invoiceid='" . $chk . "' where invoiceid=" . $val);
                dquery("delete from tbl_invoices where id='" . $val . "'");
            }
        }
        dquery("UPDATE tbl_invoiceitems SET qnt=concat('m_',id) \n        where invoiceid='" . $chk . "' and qnt=''");
        updateInvoiceTotal($chk);
    }
    $success = "Invoice Merged successfully";
}
if ($cancelinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("update tbl_invoices set status='Cancel' where id=" . $val);
    }
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
echo "\n ";
if ($clientDetails["usertype"] == "3") {
    echo "<div id=notification1 class=info>" . $LNG["logineedres"] . "</div>";
    exit;
}
include_once DATAGRID_DIR2 . "comm.php";
if ($proforma) {
    $by = " and mask!='0' and  (status='Unpaid' or status='Cancel')";
} else {
    $by = "  and status='Paid'";
}
if ($byadmin) {
    $by .= " AND adminid!=''";
} else {
    if ($byuser == 1) {
        $by .= " AND adminid=''";
    }
}
$sql = "SELECT\ntbl_invoices.id,\ntbl_invoices.mask,IF(status='Unpaid',concat('P/',mask),concat('I/',mask) ) as invoiceno,\n\nIF( (select `value` from tbl_paymentgateways where \ngateway=tbl_invoices.paymentmethod and setting='active' limit 1)=1 ,\n\n\nconcat((select \n(select value from tbl_paymentgateways where tbl_paymentgateways.gateway=tbl_transaction.gateway and setting='name') \nfrom tbl_transaction where invoiceid=tbl_invoices.id limit 1),'')\n,\nconcat(IF(tbl_invoices.paymentmethod='','Credit',tbl_invoices.paymentmethod),'')\n)\n\nas payment\n,\n \nCONCAT(\nCONCAT(tbl_invoices.total-\n(SELECT sum( amountin ) as tp FROM tbl_transaction WHERE \n(SELECT STATUS FROM tbl_invoices WHERE id = invoiceid limit 1) = 'Unpaid'\nAND invoiceid=tbl_invoices.id\nAND userid = '" . $id . "')),' ',(SELECT code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=tbl_invoices.userid))) as pending,\nCONCAT(tbl_invoices.total,' ',(SELECT code from tbl_currencies where tbl_currencies.id=(select default_currency from tblUsers where tblUsers.id=tbl_invoices.userid))) as total, \ntbl_invoices.credit, \nIF (tbl_invoices.status = 'Paid',CONCAT('<span class=textgreen>',tbl_invoices.status,'</span>'),IF(tbl_invoices.status = 'Unpaid',CONCAT('<span class=textred>',tbl_invoices.status,'</span>'),IF(tbl_invoices.status = 'Cancelled',CONCAT('<span class=textblue>',tbl_invoices.status,'</span>'),CONCAT('<span class=textbrown>',tbl_invoices.status,'</span>')))) as status, \ntbl_invoices.date,\ntbl_invoices.duedate,\nif(tbl_invoices.datepaid = 0,' ',tbl_invoices.datepaid) as datepaid,\nif(tbl_invoices.duedate < CURDATE() and status='Unpaid','" . $img_red . "','" . $img_trans . "') as flag,\nCONCAT('<a class=\"editdata\" \n onclick=\"load_subpage(\\'main2.php?page=edituser.editinvoice&id=',tbl_invoices.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["invoice"] . " [#',IF(tbl_invoices.status='Unpaid',concat('P/',tbl_invoices.mask),concat('I/',tbl_invoices.mask) ),']\\');\">" . $LNG["edit"] . "</a>')\nas action_links\nFROM tbl_invoices WHERE tbl_invoices.userid=" . $id . " " . $by;
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR2);
$default_order_field = "id";
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
if ($byadmin) {
    $multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Cancel selected" => ["view" => true, "flag_name" => "cancelinvoice", "flag_value" => "yes", "tooltip" => "Cancel selected"], "Delete selected" => ["view" => true, "flag_name" => "deleteinvoice", "flag_value" => "yes", "tooltip" => "Delete selected"], "Cancel and Rebate" => ["view" => true, "flag_name" => "rebateinvoice", "flag_value" => "yes", "tooltip" => "Cancel and Rebate"]];
} else {
    if ($by != "and adminid!=''") {
        $multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Cancel selected" => ["view" => true, "flag_name" => "cancelinvoice", "flag_value" => "yes", "tooltip" => "Cancel selected"], "Delete selected" => ["view" => true, "flag_name" => "deleteinvoice", "flag_value" => "yes", "tooltip" => "Delete selected"]];
    } else {
        $multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Cancel selected" => ["view" => true, "flag_name" => "cancelinvoice", "flag_value" => "yes", "tooltip" => "Cancel selected"], "Merge selected" => ["view" => true, "flag_name" => "merge", "flag_value" => "yes", "tooltip" => "Merge selected"]];
    }
}
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "proforma", "laoddefaultpage", "pass", "id", "by", "byadmin", "byuser"];
$dgrid->SetHttpGetVars($http_get_vars);
$dg_caption = "";
$dgrid->SetCaption($dg_caption);
$printing_option = true;
$dgrid->AllowPrinting($printing_option);
$exporting_option = true;
$exporting_directory = "tmp/";
$dgrid->AllowExporting($exporting_option, $exporting_directory);
$exporting_types = ["excel" => "false", "pdf" => "false", "xml" => "false"];
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
$fill_from_status = ["Paid" => "Paid", "Unpaid" => "Unpaid", "Cancel" => "Cancelled", "Refunded" => "Refunded"];
$filtering_fields = ["Status" => ["type" => "dropdownlist", "table" => "tbl_invoices", "field" => "status", "field_view" => "", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_invoices", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
if ($proforma) {
    $vm_colimns = ["invoiceno" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "id" => ["header" => $LNG["reference"] . " " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "date" => ["header" => $LNG["create"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "duedate" => ["header" => $LNG["due"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "datepaid" => ["header" => $LNG["paid"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "flag" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "total" => ["header" => (string) $LNG["total"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "pending" => ["header" => (string) $LNG["pending"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "50", "case" => "normal", "source" => $fill_from_status], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
} else {
    $vm_colimns = ["invoiceno" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "id" => ["header" => $LNG["reference"] . " " . $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "20", "case" => "normal"], "payment" => ["header" => (string) $LNG["payment"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => $LNG["create"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "duedate" => ["header" => $LNG["due"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "datepaid" => ["header" => $LNG["paid"] . " " . $LNG["date"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "flag" => ["header" => (string) $LNG["flag"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "total" => ["header" => (string) $LNG["total"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "pending" => ["header" => (string) $LNG["pending"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "center", "wrap" => "nowrap", "text_length" => "50", "case" => "normal", "source" => $fill_from_status], "action_links" => ["header" => (string) $LNG["actions"], "type" => "label", "align" => "right", "width" => "100px", "wrap" => "nowrap", "text_length" => "-1", "tooltip" => true, "tooltip_type" => "simple", "case" => "normal", "summarize" => "false", "sort_by" => "", "visible" => "true", "on_js_event" => ""]];
}
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_invoices";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$flags["red"] = $LNG["invoiceoverdue"];
echo displayFlag($flags);
if ($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) {
    echo "</div> ";
}
echo "    </div>\n";
$fileverioncheck = "6.1.0";

?>