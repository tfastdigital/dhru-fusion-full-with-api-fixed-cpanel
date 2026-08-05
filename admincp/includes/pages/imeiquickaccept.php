<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 366;
checkPagePermission($pageid);
if ($reason) {
    $_SESSION["reason"] = $reason;
    echo $_SESSION["reason"];
    exit;
}
if ($resubmit) {
    $resubmit = trim($resubmit, ",");
    dquery("update tbl_order_imei set fetchapitime='',apierror=''\n    where order_id in (" . $resubmit . ")");
    dquery("DELETE FROM tbl_apilog where orderid in (" . $resubmit . ") and `result`='Sending'");
}
echo "    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n    <script>\n        function ResubmitOrder()\n        {\n            var orders='';\n            \$('div.responsive-table input[type=checkbox]').each(function() {\n                if (\$(this).is(\":checked\")) {\n                    orders+=\$(this).attr('value')+',';\n                }\n            });\n            orders=orders.trim(\",\");\n            if(orders) {\n                location.href='main2.php?page=imeiorder&laoddefaultpage=imeiquickaccept.php&stype=";
echo $stype;
echo "&id=";
echo $id;
echo "&resubmit='+orders;\n            }else{\n                alert(\"select atleast one order to connect with APi\");\n            }\n        }\n        function requeorder(orderid){\n            \$.post(\"includes/pages/resetorderstat.php?orderid=\"+orderid, function(data, status){\n                \$(\".order\"+orderid).removeClass('fa');\n                \$(\".order\"+orderid).removeClass('fa-exclamation-triangle');\n                \$(\".order\"+orderid).removeClass('tooltipcolor');\n                \$(\".ts\"+orderid).remove();\n            });\n        }\n    </script>\n    <script>\n        function copytoClipboard(val)\n        {\n            var el = document.createElement('textarea');\n            el.value = val;\n            el.setAttribute('readonly', '');\n            el.style = {position: 'absolute', left: '-9999px'};\n            document.body.appendChild(el);\n            el.select();\n            document.execCommand('copy');\n            document.body.removeChild(el);\n            alert(\"Copied the text: \" + val);\n        }\n        function copyAll()\n        {\n            var orders='';\n            \$('div.checkbox input[type=checkbox]').each(function() {\n                if (\$(this).is(\":checked\")) {\n                    orders+=\$(\".sel_\"+\$(this).attr('value')).html()+\"\\n\";\n                }\n            });\n\n            orders=orders.trim(\"\\n\");\n\n            copytoClipboard(orders);\n        }\n        function ConnectToAPI()\n        {\n            var orders='';\n            \$('div.checkbox input[type=checkbox]').each(function() {\n                if (\$(this).is(\":checked\")) {\n                    orders+=\$(this).attr('value')+',';\n                }\n            });\n            orders=orders.trim(\",\");\n            if(orders) {\n                \$.post(\"includes/pages/checkorder.php?o=\" + orders, function (data, status) {\n                    var perform=true;\n                    if(data!='OK') {\n                        perform=false;\n                        if(confirm(\"Current selection contains more than one Service Are you sure want to Connect ?\")){\n                            perform=true;\n                        }\n                    }\n                    if(perform){\n                        load_subpage('main2.php?page=connectapi&o='+orders,'Connect API');\n                    }\n                });\n            }else{\n                alert(\"select atleast one order to connect with APi\");\n            }\n        }\n\n        function setCookies(val){\n\n            var c_name='AdmAuto';\n            var value=val;\n            var exdays=365;\n            if(val){\n                var exdate=new Date();\n                exdate.setDate(exdate.getDate() + exdays);\n                var c_value=escape(value) + ((exdays==null) ? \"\" : \"; expires=\"+exdate.toUTCString());\n                document.cookie=c_name + \"=\" + c_value;\n            }else{\n                var exdays=-1;\n                var exdate=new Date();\n                exdate.setDate(exdate.getDate() + exdays);\n                var c_value=escape(value) + ((exdays==null) ? \"\" : \"; expires=\"+exdate.toUTCString());\n                document.cookie=c_name + \"=\" + c_value;\n            }\n        }\n        function setValuetoSession(val){\n            \$.post(\"includes/pages/checkorder.php?setreason=\"+val, function(data, status){\n            });\n        }\n        function getCookie(c_name) {\n            var i,x,y,ARRcookies=document.cookie.split(\";\");\n            for (i=0;i<ARRcookies.length;i++)\n            {\n                x=ARRcookies[i].substr(0,ARRcookies[i].indexOf(\"=\"));\n                y=ARRcookies[i].substr(ARRcookies[i].indexOf(\"=\")+1);\n                x=x.replace(/^\\s+|\\s+\$/g,\"\");\n                if (x==c_name)\n                {\n                    return unescape(y);\n                }\n            }\n        }\n        \$(document).ready(function() {\n            var co=getCookie(\"AdmAuto\");\n            \$(\"#autorefresh\").val( co ).attr('selected',true);\n            if(co){\n                setTimeout(function() {\n                    redirectedit(\"imeiorder&laoddefaultpage=imeiquickaccept.php\");\n                }, 60000*co);\n            }\n        });\n    </script>\n";
if ($stype == "remote") {
    $whereserv = " server=2";
    $commonwhere = " and useasserver=2";
} else {
    if ($stype == "server") {
        $whereserv = " server=1";
        $commonwhere = " and useasserver=1";
    } else {
        $whereserv = " server=0";
        $commonwhere = " and useasserver=0";
    }
}
include ROOTDIR . "/includes/clients.fun.inc.php";
if ($acceptall) {
    $ctime = time();
    if (!isset($show)) {
        $order = dquery("SELECT `order_id` FROM `tbl_order_imei` \n        WHERE  `user_can_c`='0' and \n          service_id in (select id from tbl_services_imei where 1=1 " . $commonwhere . ")");
        while ($rows = mysqli_fetch_assoc($order)) {
            $_order[] = $rows["order_id"];
        }
        if ($_order) {
            $order = implode(",", $_order);
            $_SESSION["tmp_orders"] = $order;
            dquery("update `tbl_order_imei` set `user_can_c`='1',acceptedtime='" . $ctime . "',acceptedby='" . $_SESSION["adminid"] . "'\n             where `order_id` IN (" . $order . ") AND `user_can_c`='0'");
            $success = $LNG["orderaccepted"];
        } else {
            $order = $_SESSION["tmp_orders"];
        }
    } else {
        $order = $_SESSION["tmp_orders"];
    }
    include "quickacceptedorder.php";
    exit;
}
if ($rejectorder) {
    include_once ROOTDIR . "/includes/imeiservices.fun.php";
    $order = explode("-", $rid);
    foreach ($order as $o) {
        if (rejectIMEI(md5($o), $_SESSION["rejectreason"] ? html_entity_decode($_SESSION["rejectreason"]) : $LNG["rejectedorder"] . " " . $LNG["byadmin"], $_SESSION["adminid"], "", "", "", $o, false)) {
        }
    }
    replyRejectIMEI_sendmail();
    unset($_SESSION["rejectreason"]);
    echo "<div id=notification1 class=successbox>" . $LNG["order"] . " " . $LNG["rejectedorder"] . " " . $LNG["successfully"] . "</div>";
}
if ($acceptorder) {
    $ctime = time();
    $order = str_replace("-", ",", $rid);
    dquery("update `tbl_order_imei` set `user_can_c`='1',acceptedtime='" . $ctime . "',\n    acceptedby='" . $_SESSION["adminid"] . "' where `order_id` IN (" . $order . ") \n    AND `user_can_c`='0'");
    $success = $LNG["orderaccepted"];
    include "quickacceptedorder.php";
    exit;
}
include DATAGRID_DIR . "comm.php";
$sql = "SELECT \nconcat(date,' ',date_format( from_unixtime( time ) , '%h:%m:%s' ) ) as date\n,concat('<a href=\"javascript:copytoClipboard(\\'',imei,'\\')\"><i class=\"fa fa-copy\"> </i><span class=\"ml-1 sel_',order_id,'\">',imei,'</span></a>') as imei,\nIF(apierror!='' AND (user_can_c='0' or user_can_c='1' or  user_can_c='8')\n,concat('<i style=\"cursor:pointer;\" onclick=\"requeorder(',order_id,')\"  class=\"fa fa-exclamation-triangle  tooltipcolor order',order_id,'\">',order_id,'<span class=\"tooltiptext ts',order_id,'\"><strong>" . $LNG["apiprocessingerror"] . "</strong>',apierror,IF(user_can_c=0 or user_can_c=1,concat('<br /><a style=\"color:white;font-size:12px;\" >Click  to Reset</a>'),''),'</span></i>'),order_id) as order2\n, order_id,\nCONCAT(TRUNCATE( credit - discount,2 )) AS total, CONCAT( IF( tbl_order_imei.reseller_id !=0, CONCAT( TRUNCATE( (\ncredit - discount\n), 2 ) , ' / ', TRUNCATE( (\nreseller_credit - reseller_discount\n), 2 ) ) , TRUNCATE( (\ncredit - discount\n), 2 ) ) , ' ', (\n\nSELECT code\nFROM tbl_currencies\nWHERE id = (\nSELECT default_currency\nFROM tblUsers\nWHERE id = user_id ) )\n) AS curtotal2, CONCAT( (\nTRUNCATE(credit - discount,2)\n), ' ', (\n\nSELECT code\nFROM tbl_currencies\nWHERE id = tblUsers.default_currency\n) ) AS curtotal, \n\nconcat('<div class=\"boxes\" style=\"background-color:',\n(select `colortag` FROM `tbl_services_imei` WHERE `id`=tbl_order_imei.service_id),'\"></div>',\n(SELECT `service_name` FROM `tbl_services_imei` WHERE `id`=tbl_order_imei.service_id)) as service\n, (\n\nSELECT `username`\nFROM `tblUsers`\nWHERE `id` = tbl_order_imei.user_id\n) AS username,IF(qnt=0,1,qnt) as qnt,\n\n\nIF(\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='customname' limit 1)!='',\nconcat(\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='customname' limit 1),' [',\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='name' limit 1),']'\n)\n,\n(select value from tbl_apiservers where gateway=`ORDERAPI` and setting='name' limit 1) \n) as gateway\n\n\nFROM `tbl_order_imei`\nLEFT OUTER JOIN tblUsers ON `tbl_order_imei`.user_id = tblUsers.id\n where user_can_c='0' \n and  " . $whereserv;
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$messaging = true;
$unique_prefix = "";
$dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
$default_order_field = "order_id";
if ($config["orderdisplay"] == 2) {
    $default_order_type = "ASC";
} else {
    $default_order_type = "DESC";
}
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
$http_get_vars = ["page", "accesskey", "display_errors", "pass", "id", "laoddefaultpage", "stype"];
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
$pages_array = ["500" => "500", "1000" => "1000", "1500" => "1500", "2000" => "2000", "2500" => "2500"];
$default_page_size = 500;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_status = ["New Order", "In Process", "3" => "Rejected Order", "4" => "Available Order"];
$fill_from_verified = ["1" => "Pending Order for verification", "2" => "Order Verified"];
$sql = dquery("SELECT * from tbl_services_imei WHERE 1=1 " . $commonwhere);
while ($row = mysqli_fetch_assoc($sql)) {
    $arrfrom[$row["id"]] = $row["service_name"];
}
$api = dquery("select distinct gateway,value from tbl_apiservers,tbl_services_imei where tbl_apiservers.gateway=tbl_services_imei.API and tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    $gp = mysqli_fetch_assoc(dquery("select value from tbl_apiservers\n    where gateway='" . $rowapi["gateway"] . "' and setting='customname'"));
    $fill_from_api[$rowapi["gateway"]] = $rowapi["value"] . " " . $gp["value"];
}
if (!count($fill_from_api)) {
    $fill_from_api[1] = "";
}
if ($stype == "server" || $stype == "remote") {
    $filtering_fields = ["Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "service_id", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => "", "source" => $arrfrom], "API" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "API", "field_view" => "API", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "subquery" => "(SELECT API FROM tbl_services_imei WHERE id = service_id)", "show_operator" => "false", "default_operator" => "subquery", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
} else {
    $filtering_fields = ["Username" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Service" => ["type" => "dropdownlist", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "service_id", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => "", "source" => $arrfrom], "API" => ["type" => "dropdownlist", "table" => "tbl_order_imei", "field" => "API", "field_view" => "API", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_api, "condition" => "", "subquery" => "(SELECT API FROM tbl_services_imei WHERE id = service_id)", "show_operator" => "false", "default_operator" => "subquery", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "IMEI" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_order_imei", "field" => "imei", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_order_imei", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
}
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
if ($stype == "server" || $stype == "remote") {
    $vm_colimns = ["order2" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "username" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gateway" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "qnt" => ["header" => (string) $LNG["qnt"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "curtotal" => ["header" => "Credit <br /><small>User/Reseller</small>", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
} else {
    $vm_colimns = ["order2" => ["header" => (string) $LNG["id"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "service" => ["header" => (string) $LNG["service"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "gateway" => ["header" => (string) $LNG["gateway"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "username" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "curtotal" => ["header" => "Credit <br /><small>User/Reseller</small>", "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "imei" => ["header" => (string) $LNG["imei"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
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
echo "    <div>\n        &nbsp;<img style=\"padding:0px; margin:0px; border:0px;\" src=\"includes/3rdparty/datagrid/styles/default/images/arrow_ltr.png\" width=\"38\" height=\"22\" alt=\"With selected\" title=\"\">\n        <span ><i>with selected</i></span>\n        &nbsp;<strong onclick=\"copyAll()\">Copy IMEI</strong>\n        &nbsp;&nbsp;&nbsp;\n        <input type=\"button\" style=\"font-size: 11px;\"\n               onclick=\"javascript: ConnectToAPI();\"\n               name=\"connectapi\" value=\"Connect APi\" />\n\n        &nbsp;&nbsp;&nbsp;\n        <input type=\"button\" style=\"font-size: 11px;\"\n               onclick=\"javascript: ResubmitOrder();\"\n               name=\"resubmitorder\" value=\"Resubmit Order\" />\n    </div>\n\n    <div style=\"float: right;\">\n        Auto Refresh:\n        <select name=\"autorefresh\" id=\"autorefresh\"\n                onchange=\"javascript: setCookies(this.value);\">\n            <option value=\"\">Disabled</option>\n            <option value=\"5\">5 Miniute</option>\n            <option value=\"10\">10 Miniute</option>\n            <option value=\"30\">30 Miniute</option>\n            <option value=\"60\">1 Hour</option>\n        </select>\n\n\n    </div>";
$fileverioncheck = "6.1.0";

?>