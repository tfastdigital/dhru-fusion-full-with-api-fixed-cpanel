<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n<style>\n    .boxes{\n        width: 10px;\n        height: 10px;\n        float:left;\n        margin-top: 4px;\n        margin-right: 4px;\n    }\n    .hideme{\n        display:none;\n    }\n    .ts{\n        margin-left: 700px !important;\n        margin-top: 80px !important;\n    }\n</style>\n\n";
$pageid = 373;
checkPagePermission($pageid);
if ($_ff_onSUBMIT_FILTER == "Search" || $action == "edit" || $p) {
    include "productorder.head.php";
    echo "<div id='tabcontent'>";
}
include DATAGRID_DIR . "comm.php";
if ($status == "pendings") {
    $usercanc = "`user_can_c`='0'";
} else {
    $usercanc = "`user_can_c`<='5'";
}
if ($action == "refund" && $ids) {
    $sql = "SELECT \n    order_id,\n    date,\n    tbl_order_product.credit,\n    tbl_order_product.discount, \n    tbl_order_product.reply,\n    IF(tbl_order_product.buyadvance=1,CONCAT(tbl_order_product.invoiceid,' ','[" . $LNG["preorder"] . "]'),tbl_order_product.invoiceid) as invoiceid,  \n    tbl_order_product.credit-tbl_order_product.discount as total,   \n    CONCAT((select subtotal from tbl_invoices where id=tbl_order_product.invoiceid),' ',(SELECT code FROM tbl_currencies where id=tblUsers.default_currency)) AS curtotal,\n    CONCAT((SELECT `service_name` FROM `tbl_products` WHERE `id`=tbl_order_product.service_id),IF(gift=1,' [" . $LNG["gift"] . "]','')) AS service,\n    imei,\n    (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_product.user_id) as username,\n    CONCAT(IF(tbl_order_product.user_can_c=0,'New', IF(tbl_order_product.user_can_c=1,'In Process',IF(tbl_order_product.user_can_c=4,'Sent',IF(tbl_order_product.user_can_c=6,'On Hold',IF(tbl_order_product.user_can_c=7,'Received','Rejected'))))) ) as status,\n    CONCAT( '<a class=\\'default_dg_a editdata\\' href=\"javascript:load_fromsubpage(\\'productorder.edit&id=',tbl_order_product.invoiceid,'\\',\\'Edit Product Order ',tbl_order_product.invoiceid,'\\')\">" . $LNG["edit"] . "</a>' )  AS action  \n    FROM `tbl_order_product` \n    LEFT OUTER JOIN tblUsers ON `tbl_order_product`.user_id = tblUsers.id \n    LEFT OUTER JOIN tbl_products ON tbl_order_product.service_id=tbl_products.id\n     WHERE `user_can_c`='3' and service_id='" . $ids . "' " . $where . " GROUP by invoiceid";
    echo "    <div id=\"tabcontent\">\n    ";
} else {
    $sql = "SELECT \n\norder_id,\n    CONCAT( '<a  href=\"javascript:load_fromsubpage(\\'productorder.edit&id=',tbl_order_product . invoiceid,'\\',\\'Edit Product Order ',tbl_order_product . invoiceid,'\\')\">#',tbl_order_product.invoiceid,'</a>' )  AS orders,\n    concat(FROM_UNIXTIME(tbl_order_product.time, '%M %d, %Y'),'<br />','<small>',FROM_UNIXTIME(tbl_order_product.time, '%h:%i'),'</small>' ) as dates,\n  CONCAT( '<a  href=\"javascript:load_fromsubpage(\\'edituser&id=',tbl_order_product . invoiceid,'\\',\\'Customer : ',tblUsers . username,'\\')\">',  concat(first_name,' ',last_name,'<br/><small>',email,'</small>'),'</a>' ) as customer,\n   CONCAT(IF((select onhold from tbl_invoices where tbl_invoices.id=tbl_order_product.invoiceid)=1,'<span style=\"cursor:pointer;\" class=\" tooltip \"><span class=\"tooltiptext ts\">Payment Received but manual verification required (Fraud Check Enabled)</span>','' ), '<a  href=\"javascript:load_fromsubpage(\\'edituser.editinvoice&id=',tbl_order_product . invoiceid,'\\',\\'Invoice # ',tbl_order_product . invoiceid,'\\')\">', (select IF(onhold=1,'<span class=\"badge badge-warning\">On Hold</span>',IF(status='Unpaid', IF(receivedamount>0,'<span class=\"badge badge-info\">Partially Paid</span>','<span class=\"badge badge-danger\">Waiting Payment</span>'),'<span class=\"badge badge-success\">Paid</span>')) from tbl_invoices where tbl_invoices.id=tbl_order_product.invoiceid),'</a>',IF((select onhold from tbl_invoices where tbl_invoices.id=tbl_order_product.invoiceid)=1,'</span>','' ) ) as payment,\n    tbl_order_product.credit,\n    tbl_order_product.discount, \n    tbl_order_product.reply,\n    IF(tbl_order_product.buyadvance=1,CONCAT(tbl_order_product.invoiceid,' ','[" . $LNG["preorder"] . "]'),tbl_order_product.invoiceid) as invoiceid,  \n    tbl_order_product.credit-tbl_order_product.discount as total,   \n    concat((select total from tbl_invoices where tbl_invoices.id=tbl_order_product.invoiceid),' ',(SELECT code FROM tbl_currencies where id=tblUsers.default_currency),'<br/> <small> Qty: ',(select count(id) from tbl_invoiceitems where tbl_invoiceitems.invoiceid=tbl_order_product.invoiceid),'</small>') as amount,   \n    CONCAT((select subtotal from tbl_invoices where id=tbl_order_product.invoiceid),' ',(SELECT code FROM tbl_currencies where id=tblUsers.default_currency)) AS curtotal,\n    CONCAT((SELECT `service_name` FROM `tbl_products` WHERE `id`=tbl_order_product.service_id),IF(gift=1,' [" . $LNG["gift"] . "]','')) AS service,\n    imei,\n    (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_product.user_id) as username,\n    CONCAT(IF(tbl_order_product.user_can_c=0,'New', IF(tbl_order_product.user_can_c=1,'In Process',IF(tbl_order_product.user_can_c=4,'Dispatched',IF(tbl_order_product.user_can_c=6,'On Hold',IF(tbl_order_product.user_can_c=7,'Delivered','Rejected'))))) ) as status,\n    CONCAT( '<a class=\\'default_dg_a editdata\\' href=\"javascript:load_fromsubpage(\\'productorder.edit&id=',tbl_order_product.invoiceid,'\\',\\'Edit Product Order ',tbl_order_product.invoiceid,'\\')\">" . $LNG["edit"] . "</a>' )  AS action  \n    FROM `tbl_order_product` \n    LEFT OUTER JOIN tblUsers ON `tbl_order_product`.user_id = tblUsers.id \n    LEFT OUTER JOIN tbl_products ON tbl_order_product.service_id=tbl_products.id\n     WHERE " . $usercanc . "  GROUP by invoiceid";
}
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "order_id";
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
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id"];
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
$fill_from_status = ["New Order", "Un-Shipped", "3" => "Rejected", "4" => "Dispatched", "6" => "On Hold", "7" => "Delivered"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT `id`,`service_name` FROM `tbl_products`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $service[$rows["id"]] = $rows["service_name"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_admin`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $admins[$rows["id"]] = $rows["username"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_supplier`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $suppl[$rows["id"]] = $rows["username"];
}
$sql = dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='name'");
while ($rows = mysqli_fetch_assoc($sql)) {
    $apis[$rows["gateway"]] = $rows["value"];
}
$sql = dquery("SELECT `id`,`username` FROM `tbl_supplier`");
while ($rows = mysqli_fetch_assoc($sql)) {
    $suppl[$rows["id"]] = $rows["username"];
}
$filtering_fields = ["Order ID" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_product", "field" => "invoiceid", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Item" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/product.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_products", "field" => "service_name", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_order_product", "field" => "user_can_c", "field_view" => "user_can_c", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_product", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["orders" => ["header" => (string) $LNG["order"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "dates" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "customer" => ["header" => (string) $LNG["customer"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "payment" => ["header" => $LNG["payment"] . " " . $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => $LNG["fulfillment"] . " " . $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "10", "case" => "normal"], "amount" => ["header" => (string) $LNG["amount"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_product";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div>";
}
if ($action == "refund" && $id) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>