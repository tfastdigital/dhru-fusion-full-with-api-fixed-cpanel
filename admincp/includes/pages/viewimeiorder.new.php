<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 197;
checkPagePermission($pageid);
if ($stype == "server") {
    $whereserv = " server=1";
    $commonwhere = " and useasserver=1";
} else {
    $whereserv = " server=0";
    $commonwhere = " and useasserver=0";
}
$row = mysqli_fetch_assoc(dquery("select service_name from\n tbl_services_imei where id='" . $id . "'"));
if ($resubmit) {
    $resubmit = trim($resubmit, ",");
    dquery("update tbl_order_imei set fetchapitime='',apierror=''\n    where order_id in (" . $resubmit . ")");
    dquery("DELETE FROM tbl_apilog where orderid in (" . $resubmit . ") and `result`='Sending'");
}
echo "<!--<button value=\"export\" >Export Orders</button>-->\n<script>\nfunction requeorder(orderid){\n    \$.post(\"includes/pages/resetorderstat.php?orderid=\"+orderid, function(data, status){\n        \$(\".order\"+orderid).removeClass('fa');\n        \$(\".order\"+orderid).removeClass('fa-exclamation-triangle');\n        \$(\".order\"+orderid).removeClass('tooltipcolor');\n        \$(\".ts\"+orderid).remove();\n    });\n}\n</script>\n<script>\n    function copytoClipboard(val)\n    {\n\n        var el = document.createElement('textarea');\n        el.value = val;\n        el.setAttribute('readonly', '');\n        el.style = {position: 'absolute', left: '-9999px'};\n        document.body.appendChild(el);\n        el.select();\n        document.execCommand('copy');\n        document.body.removeChild(el);\n        alert(\"Copied the text: \" + val);\n    }\n    function ResubmitOrder()\n    {\n        var orders='';\n        \$('div.responsive-table input[type=checkbox]').each(function() {\n            if (\$(this).is(\":checked\")) {\n                orders+=\$(this).attr('value')+',';\n            }\n        });\n        orders=orders.trim(\",\");\n        if(orders) {\n            location.href='main2.php?page=imeiorder&laoddefaultpage=viewimeiorder.new.php&stype=";
echo $stype;
echo "&id=";
echo $id;
echo "&resubmit='+orders;\n        }else{\n            alert(\"select atleast one order to connect with APi\");\n        }\n    }\n    function ConnectToAPI()\n    {\n        var orders='';\n        \$('div.responsive-table input[type=checkbox]').each(function() {\n            if (\$(this).is(\":checked\")) {\n                orders+=\$(this).attr('value')+',';\n            }\n        });\n        orders=orders.trim(\",\");\n        if(orders) {\n            \$.post(\"includes/pages/checkorder.php?o=\" + orders, function (data, status) {\n                var perform=true;\n                if(data!='OK') {\n                    perform=false;\n                    if(confirm(\"Current selection contains more than one Service Are you sure want to Connect ?\")){\n                        perform=true;\n                    }\n                }\n                if(perform){\n                    load_subpage('main2.php?page=connectapi&o='+orders,'Connect API');\n                }\n            });\n        }else{\n            alert(\"select atleast one order to connect with APi\");\n        }\n        //\$(\"modal\")\n    }\n    function setValuetoSession(val){\n        \$.post(\"includes/pages/checkorder.php?setreason=\"+val, function(data, status){\n        });\n    }\n    subheader2_txt('[";
echo $LNG["view"];
echo " ";
echo $LNG["order"];
echo ": ";
echo $row["service_name"];
echo "]');\n</script>\n";
if ($_ff_onSUBMIT_FILTER == "Search" || $rejectorder || $p) {
    include "imeiorder.head.php";
    echo "<div id='tabcontent'>";
}
include ROOTDIR . "/includes/clients.fun.inc.php";
if ($acceptall) {
    $ctime = time();
    if (!isset($show)) {
        $order = dquery("SELECT `order_id` FROM `tbl_order_imei` \n        WHERE `service_id`='" . $id . "' AND `user_can_c`='0' and " . $whereserv);
        while ($rows = mysqli_fetch_assoc($order)) {
            $_order[] = $rows["order_id"];
        }
        if ($_order) {
            $order = implode(",", $_order);
            $_SESSION["tmp_orders"] = $order;
            dquery("update `tbl_order_imei` set `user_can_c`='1',acceptedtime='" . $ctime . "',acceptedby='" . $_SESSION["adminid"] . "' where \n            `order_id` IN (" . $order . ") AND `user_can_c`='0'");
            $success = $LNG["orderaccepted"];
        } else {
            $order = $_SESSION["tmp_orders"];
        }
    } else {
        $order = $_SESSION["tmp_orders"];
    }
    include "acceptedorder.php";
    exit;
}
if ($rejectorder) {
    include_once ROOTDIR . "/includes/imeiservices.fun.php";
    $order = explode("-", $rid);
    foreach ($order as $o) {
        if (rejectIMEI(md5($o), $_SESSION["rejectreason"] ? $_SESSION["rejectreason"] : $LNG["rejectedorder"] . " " . $LNG["byadmin"], $_SESSION["adminid"], "", "", "", $o, false)) {
        }
    }
    replyRejectIMEI_sendmail();
    unset($_SESSION["rejectreason"]);
    echo "<div id=notification1 class=successbox>" . $LNG["order"] . " " . $LNG["rejectedorder"] . " " . $LNG["successfully"] . "</div>";
}
if ($acceptorder) {
    $ctime = time();
    $order = str_replace("-", ",", $rid);
    dquery("update `tbl_order_imei` set `user_can_c`='1',acceptedtime='" . $ctime . "',\n\n    acceptedby='" . $_SESSION["adminid"] . "' where \n    `order_id` IN (" . $order . ") AND `user_can_c`='0'");
    $success = $LNG["orderaccepted"];
    include "acceptedorder.php";
    exit;
}
include DATAGRID_DIR . "comm.php";
$sql = "SELECT \norder_id\n,\n \n IF(apierror!='' AND (user_can_c='0' or user_can_c='1' or  user_can_c='8')\n,concat('<i style=\"cursor:pointer;\" onclick=\"requeorder(',order_id,')\"  class=\"fa fa-exclamation-triangle  tooltipcolor order',order_id,'\">',order_id,'<span class=\"tooltiptext ts',order_id,'\"><strong>" . $LNG["apiprocessingerror"] . "</strong>',apierror,IF(user_can_c=0 or user_can_c=1,concat('<br /><a style=\"color:white;font-size:12px;\" >Click  to Reset</a>'),''),'</span></i>'),order_id) as order2\n ,concat(date,' ',date_format( from_unixtime( time ) , '%h:%m:%s' ) ) as date, \nconcat('<a href=\"javascript: copytoClipboard(\\'',imei,'\\')\"><i class=\"fa fa-copy\"></i>',IF(tmp_status=9,concat('[A] ',imei), IF(ebay=1, concat('[D] ',imei), IF(retail_shop=1,concat('[R] ',imei),imei) ) ),'</a>') as imei,\nCONCAT(TRUNCATE(credit-discount,2)) as total,\nIF(qnt=0,1,qnt) as qnt,\nCONCAT(IF(tbl_order_imei.reseller_id!=0,\nCONCAT((TRUNCATE(credit-discount,2)),' / ',\n(TRUNCATE(reseller_credit-reseller_discount,2))),\n(TRUNCATE(credit-discount,2))),' ',\n(SELECT code FROM tbl_currencies where id=(select default_currency \nfrom tblUsers where id=user_id))) AS curtotal,\nCONCAT(IF(model_id='','',(SELECT Name FROM tbl_model_brand where tbl_model_brand.ID=model_id)),' ',\nIF(provider_id='','',(SELECT Name FROM tbl_provider where tbl_provider.ID=provider_id)),' ',\nIF(PIN='','',PIN),' ',\nIF(KBH='','',KBH),' ',\nIF(PRD='','',PRD),' ',\nIF(Type='','',Type),' ',\nIF(Reference='','',Reference)\n) as field,\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\" >',tbl_order_imei.ip,'</a>') AS ips,\n(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_imei.user_id) as username\nFROM `tbl_order_imei`  where user_can_c='0' AND  service_id =" . $id;
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
$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Accept Order" => ["view" => true, "flag_name" => "acceptorder", "flag_value" => "yes", "tooltip" => (string) $LNG["acceptselected"]], "Accept All" => ["view" => true, "flag_name" => "acceptall", "flag_value" => "yes", "tooltip" => (string) $LNG["acceptall"], "skipselectedrow" => true], "Reject Order" => ["view" => true, "flag_name" => "rejectorder", "flag_value" => "yes", "tooltip" => "Reject Selected"], "Reject Reason" => ["view" => true, "boxtype" => "textbox", "flag_name" => "rejectreason", "flag_value" => "yes", "tooltip" => "Reject Reason", "skipselectedrow" => true]];
$dgrid->SetMultirowOperations($multirow_operations);
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage", "year", "stype"];
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
$default_page_size = 500;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
if ($supplieraccess) {
    $filtering_fields = ["IMEI" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "imei", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
} else {
    $filtering_fields = ["IMEI" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "imei", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
}
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
if ($stype == "server") {
    $vm_colimns = ["order2" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "qnt" => ["header" => (string) $LNG["qnt"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "field" => ["header" => (string) $LNG["fields"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "curtotal" => ["header" => $LNG["total"] . " " . $LNG["credit"] . " <br ><small>" . $LNG["user"] . "/" . $LNG["reseller"] . "</small>", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "25", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "ips" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
} else {
    $vm_colimns = ["order2" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "imei" => ["header" => (string) $LNG["imei"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "field" => ["header" => (string) $LNG["fields"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "curtotal" => ["header" => $LNG["total"] . " " . $LNG["credit"] . " <br ><small>" . $LNG["user"] . "/" . $LNG["reseller"] . "</small>", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "25", "case" => "normal"], "username" => ["header" => (string) $LNG["username"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "ips" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
}
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_order_imei";
$primary_key = "order_id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    echo "</div>";
}
echo "    <div>\n        &nbsp;<img style=\"padding:0px; margin:0px; border:0px;\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" width=\"38\" height=\"22\" alt=\"With selected\" title=\"\">\n        <span ><i>with selected</i></span>\n        &nbsp;&nbsp;&nbsp;\n        <input type=\"button\" style=\"font-size: 11px;\"\n               onclick=\"javascript: ConnectToAPI();\"\n               name=\"connectapi\" value=\"Connect APi\" />\n\n        &nbsp;&nbsp;&nbsp;\n        <input type=\"button\" style=\"font-size: 11px;\"\n               onclick=\"javascript: ResubmitOrder();\"\n               name=\"resubmitorder\" value=\"Resubmit Order\" />\n\n    </div>\n<div style=\"float:left\" style=\"width: 80px;\">\n[A] : App Order <br />\n[R] : Retail Order <br />\n[D] : Direct Order <br />\n</div>";
$fileverioncheck = "6.1.0";

?>