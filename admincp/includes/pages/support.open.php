<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_REQUEST["_ff_onSUBMIT_FILTER"] == "Search") {
    if ($uid) {
        $tmpid = $id;
        $id = $uid;
    }
    include "edituser.head.php";
}
if ($tmpid) {
    $id = $tmpid;
}
echo "<div id=\"tabcontent\">\n<script type=\"text/javascript\" src=\"includes/3rdparty/editor/tinymce.min.js\"></script>\n";
$DonotLoad = true;
$whereuf = "";
if ($uid) {
    $whereuf = "&uid=" . $uid;
}
echo "    <style>\n        iframe{\n            min-height: 120px !important;\n        }\n    </style>\n    <script type=\"text/javascript\">\n        \$( document ).ready(function() {\n            tinymce.init({\n                selector: \"textarea\",\n                menubar:false,\n                plugins: \"link image table textcolor searchreplace\",\n                toolbar: \"  undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | forecolor backcolor | bullist numlist outdent indent removeformat | link | fontselect |  fontsizeselect \"\n            });\n        });\n\n        \$( document ).ready(function() {\n            \$('#replybox').keydown(function (e) {\n\n                if (e.ctrlKey && e.keyCode == 13) {\n                    \$('#replybutton').trigger( \"click\" );\n                }\n            });\n        });\n        function saveReplies(id){\n            var cont=tinyMCE.get('reply_'+id).getContent();\n\n            \$.post( \"includes/pages/editreply.php?id=\"+id+\"&value=\"+cont, function( data ) {\n                alert(\"Data save successfully\");\n            });\n            ///value id\n        }\n        function redirectedit3(l,o){\n            location.href='main2.php?page='+ l +'&id='+ o;\n        }\n        function activeTab(active,inactive){\n            document.getElementById(active+'_active').style.display='table';\n            document.getElementById(inactive+'_active').style.display='none';\n        }\n        var Lst;\n        function CngClass(obj){\n            if (Lst) Lst.className='';\n            obj.className='tabmenu_active';\n            Lst=obj;\n        }\n    </script>\n    <style>\n        #tab1_active{display: none;}\n        #itemstable{\n            background: #efefef;\n        }\n        #itemstable td{\n            border:2px solid #efefef;\n            padding: 5px 15px;\n        }\n        #subtabmenu{border-right: #ddd solid 1px;float: left;min-height:200px;}\n        #subtabmenu li{\n            width: 100px;\n            border: #ddd solid 1px;\n            border-right:0;\n            padding:5px;\n            margin:5px 0;\n        }\n        #tab_active,#tab1_active{padding:0 20px;margin:10px;width:60%}\n        .editreply2{background: #fcfcfc;padding:10px;float:left;margin: 4px 0;min-width:300px;max-width:650px;border-radius: 5px;border:#ccc solid 1px;position: relative;}\n        .editreply2 textarea{height:300px !important;width:600px !important}\n    </style>\n    ";
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR . "comm.php";
$sql = mysqli_fetch_assoc(dquery("select support_department from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
if ($sql["support_department"]) {
    $_SESSION["department"] = $sql["support_department"];
}
if ($mode == "delete") {
    logActivityGlobal("Support Ticket Delete #" . $rid, "support", $rid, "admin");
}
if ($replied) {
    $message = html_entity_decode($message);
    $message = str_replace("<p>&nbsp;</p>", "", $message);
    $message = str_replace("<br />", "", $message);
    $message = str_replace("<p></p>", "", $message);
    if ($tic) {
        dquery("UPDATE tbl_support_tickets SET message='" . $message . "' WHERE id='" . $tic . "'");
        echo "            <div id=\"notification1\" class=\"successbox\" >Ticket Updated</div>\n         ";
    }
}
if (($mode == "delete" || $mode == "closeall" || $mode == "mergeall" || $p) && ($id == "2" || $id == "3" || $id == "4") && !$edit) {
    echo "    <ul id=\"tabmenu\">\n        <li><a ";
    if ($id == "4") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab2','main2.php?page=support.open";
    echo $whereuf;
    echo "','4','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["waiting"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n        <li><a ";
    if ($id == "1") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab1','main2.php?page=support.open";
    echo $whereuf;
    echo "','1','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["open"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n        <li><a ";
    if ($id == "5") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab5','main2.php?page=support.open";
    echo $whereuf;
    echo "','5','','#tabcontent',true,'#main_loader');\" id=\"tab5\" >Customer-reply</a></li>\n        <li><a ";
    if ($id == "3") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=support.open";
    echo $whereuf;
    echo "','3','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["answered"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n        <li><a ";
    if ($id == "2") {
        echo "class=tabmenu_active";
    }
    echo " onclick=\"getContect('#tab4','main2.php?page=support.open";
    echo $whereuf;
    echo "','2','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["closed"];
    echo " ";
    echo $LNG["ticket"];
    echo "</a></li>\n        ";
    $sql = dquery("select * from tbl_support_status where id>4");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "            <li><a onclick=\"getContect('#tab";
        echo $row["id"];
        echo "','main2.php?page=support.open";
        echo $whereuf;
        echo "','";
        echo $row["id"];
        echo "','','#tabcontent',true,'#main_loader');\" id=\"tab";
        echo $row["id"];
        echo "\" >";
        echo $row["status"];
        echo "</a></li>\n            ";
    }
    echo "<div style=\"clear: both;\"></div>\n    </ul>\n    <div id=\"tabcontent\">\n        ";
}
if ($edit) {
    echo "            <script type=\"text/javascript\" src=\"includes/js/editinplace.js\"></script>\n            <script type=\"text/javascript\">\n                \$(\"document\").ready(function() {\n                    setClickable();\n                });\n                function setClickable() {\n                    \$('div#editInPlace').click(function() {\n                        var input = '<div id=\"after\"><input type=\"text\" style=\"width: 180px;\" value='+\$(this).html()+' name=\"replacecode\"/> <input  value=\"";
    echo $LNG["update"];
    echo "\" name=\"btnreplace\" id=\"btnreplace\" class=\"button btn save\" type=\"button\"  onclick=\"SubmitForm (\\'#btnreplace\\',\\'edituser.editserverorderreplacesuccess\\',\\'#frmedituser\\',\\'#notification\\',\\'true\\',\\'#main_loader\\');\"/>';\n                        var button= '<input type=\"button\" value=\"cancel\" class=\"btn  cancelButton\" /></div>';\n                        var revert= \$(this).html();\n                        \$(this).after(input+button).remove();\n                        \$('.cancelButton').click(function(){saveChanges(this, revert);});\n                    })\n                };\n                function saveChanges(obj, revert) {\n                    \$(obj).parent().after('<div id=\"editInPlace\">'+revert+'</div>').remove();\n                }\n                \$(function() {\n                    \$(\".editreply\").editable(\"includes/pages/editreply.php?sep=\"+\$(this).attr(\"id\") , {\n                        type   : 'textarea',\n                        submitdata: { _method: \"put\",\"bb\":\$(this).attr('id') },\n                        select : true,\n                        submit : 'OK',\n                        cancel : 'cancel'\n                    });\n                });\n            </script>\n            <div id=\"tabcontent\">\n                <div id=\"notification\"></div>\n                <div id=\"content\">\n                    <div id=\"content_padded\">\n                    ";
    $TIC = mysqli_fetch_assoc(dquery("select *,(select username from tblUsers\nwhere id=uid) as user,(select email from tblUsers where id=uid) as email from tbl_support_tickets where id='" . $edit . "'"));
    $adminread = explode(",", $TIC["admin_read"]);
    $flag = true;
    if ($TIC["admin_read"] != "") {
        foreach ($adminread as $a) {
            if ($a != $_SESSION["adminid"]) {
                $ids .= "," . $a;
            }
        }
        $ids .= "," . $_SESSION["adminid"];
    } else {
        $ids = $_SESSION["adminid"];
    }
    $ids = trim($ids, ",");
    dquery("UPDATE tbl_support_tickets set admin_read='" . $ids . "' WHERE tid='" . $TIC["tid"] . "'");
    if ($reply) {
        include_once ROOTDIR . "/includes/support.fun.php";
        $ticket["message"] = $reply;
        $ticket["subject"] = $TIC["subject"];
        if (ticket($TIC["tid"], $TIC["uid"], $_SESSION["adminid"], $TIC["name"], $TIC["email"], $TIC["did"], "", $ticket)) {
            echo "<div id=notification1 class=successbox> " . $LNG["datasave"] . " " . $LNG["savesuccessfully"] . " </div>";
        }
    }
    echo "                        <div  class=\"groupstabes\" >\n                            <h2>\n                                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                                <span class=\"groupstabesheadertext\">[#";
    echo $TIC["tid"];
    echo "] ";
    echo $TIC["subject"];
    echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n                            </h2>\n                            <div class=\"groupstabescontant\">\n                                <div>\n                                    <div id=\"supportsetting\" style=\"display: none;\">\n                                        <div id=\"content\">\n                                            <div id=\"content_padded\">\n                                                <div  class=\"groupstabes\">\n\n\n                                                </div>\n                                            </div> </div> </div>\n\n\n\n                                    <div class=\"clear\"></div>\n                                </div> </div></div>\n\n\n                        <a class=\"default_dg_a\" href=\"javascript:load_fromsubpage('edituser&id=";
    echo $TIC["uid"];
    echo "','";
    echo $TIC["user"];
    echo "')\">";
    echo $TIC["user"];
    echo "</a> [";
    echo $TIC["email"];
    echo "]\n                        <br /><br />\n                        ";
    $sql = dquery("select * from tbl_support_tickets where tid='" . $TIC["tid"] . "' ORDER BY id DESC");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "                 <div>\n                 <div class=\"editreply2\" id=\"hide_";
        echo $row["id"];
        echo "\"  title=\"";
        echo $LNG["editreplynote"];
        echo "\">\n                    <form method=\"post\" id=\"ss";
        echo $row["id"];
        echo "\" style=\"position: absolute;right:0;top:0;\">\n                        <input type=\"hidden\" name=\"id\" value=\"";
        echo $row["id"];
        echo "\" />\n                        <input value=\"X\" id=\"btnclose\" class=\"button deletedata\" type=\"button\" style=\"min-width: 20px;\"\n                               onclick=\"SubmitForm ('#btnclose','support.delete','#ss";
        echo $row["id"];
        echo "','#notification','true','#main_loader');\"/>\n                    </form>\n                 <div>\n                        <span style=\"color:black\">\n                        ";
        if ($row["aid"]) {
            $admn = mysqli_fetch_assoc(dquery("select firstname,lastname from tbl_admin where id='" . $row["aid"] . "'"));
            echo $admn["firstname"] . " " . $admn["lastname"];
        } else {
            if ($row["uid"]) {
                $user = mysqli_fetch_assoc(dquery("select first_name,last_name,username from tblUsers where id='" . $row["uid"] . "'"));
                echo $user["first_name"] . " " . $user["last_name"] . " [" . $user["username"] . "]";
            } else {
                if ($row["name"]) {
                    echo $row["name"];
                }
            }
        }
        if ($row["email"]) {
            echo $row["email"];
        }
        echo "                        </span>\n                                    </div>\n<form method=\"post\" id=\"frm";
        echo $row["id"];
        echo "\" >\n    <input type=\"hidden\" name=\"tic\" value=\"";
        echo $row["id"];
        echo "\" />\n      <div class=\"\"  id=\"";
        echo $row["id"];
        echo "\">\n            <textarea  style=\"max-height: 100px !important; width: 650px;\" name=\"message\"  id=\"reply_";
        echo $row["id"];
        echo "\">";
        echo nl2br($row["message"]);
        echo "</textarea>\n      </div>\n\n      <div style=\"padding-top:5px;margin-top:10px;\">\n       <span style=\"float: right;\"> ";
        echo $row["date"];
        echo "</span>\n       <span style=\"float: left;\">\n         <button type=\"submit\" name=\"replied\" value=\"save\"\n         class=\"btn green\">";
        echo $LNG["save"];
        echo "</button>   <a style=\"text-decoration: none;\" href=\"";
        echo $config["ip_location"];
        echo $row["ip"];
        echo "\" target=\"_blank\"> IP:";
        echo $row["ip"];
        echo "</a>\n       </span>\n      </div>\n</form>\n                                </div>\n                                <div class=\"clear\"></div>\n\n                            </div>\n\n\n                            ";
    }
    echo "                        <hr />\n<div >\n                        <form method=\"post\" id=\"\" class=\"form\">\n        <div style=\"width: 49%;float:left;\">\n            <textarea name=\"reply\"  id=\"replybox\"  style=\"vertical-align: middle; border: 1px solid #ccc;\"></textarea>\n            <input type=\"submit\" class=\"btn save\" id=\"replybutton\" name=\"save\" value=\"";
    echo $LNG["reply"];
    echo "\" />\n        </div>\n        </form>\n        <div style=\"width: 49%;float:right\">\n            <form id=\"frmsetting3344\" method=\"post\" class=\"form\">\n                <input type=\"hidden\" name=\"tid\" value=\"";
    echo $TIC["tid"];
    echo "\" />\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                    <tbody>\n                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["subject"];
    echo "</td>\n                        <td class=\"fieldarea\"><input type=\"text\" name=\"subject\" value=\"";
    echo $TIC["subject"];
    echo "\" /> </td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["status"];
    echo "</td>\n                        <td class=\"fieldarea\">\n                            <select name=\"status\">\n                                ";
    $sql = dquery("select * from tbl_support_status");
    while ($ro = mysqli_fetch_assoc($sql)) {
        echo "                                    <option style=\"color: ";
        echo $ro["color"];
        echo ";\"\n                                        ";
        if ($ro["id"] == $TIC["sid"]) {
            echo "selected";
        }
        echo "                                            value=\"";
        echo $ro["id"];
        echo "\">";
        echo $ro["status"];
        echo "</option>\n                                    ";
    }
    echo "                            </select>\n                        </td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["department"];
    echo "</td>\n                        <td class=\"fieldarea\">\n                            <select name=\"department\">\n                                ";
    $sql = dquery("select * from tbl_support_department");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "                                    <option ";
        if ($row["id"] == $TIC["did"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["department"];
        echo "</option>\n                                    ";
    }
    echo "                            </select>\n                        </td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldlabel\">";
    echo $LNG["priority"];
    echo "</td>\n                        <td class=\"fieldarea\">\n                            <select name=\"priority\">\n                                ";
    $sql = dquery("select * from tbl_support_priority");
    while ($row = mysqli_fetch_assoc($sql)) {
        echo "                                    <option style=\"color: ";
        echo $row["color"];
        echo ";\" ";
        if ($row["id"] == $TIC["pid"]) {
            echo "selected";
        }
        echo " value=\"";
        echo $row["id"];
        echo "\">";
        echo $row["priority"];
        echo "</option>\n                                    ";
    }
    echo "                            </select>\n                        </td>\n                    </tr>\n                    <tr>\n                        <td></td>\n                        <td class=\"fieldarea\">\n                            <input value=\"";
    echo $LNG["save"];
    echo "\" id=\"btnsett\" class=\"btn save\" type=\"button\"  onclick=\"SubmitForm ('#btnsett','support_setting','#frmsetting3344','#notification');\"/>\n                        </td>\n                    </tr>\n                    </tbody>\n                </table>\n            </form>\n        </div>\n\n    <br /><br /><br /><br /><br />\n</div>\n                        <br /><br />\n                    </div>\n\n                </div></div>\n<!--\n            <div class=\"fixedbtn\">\n                <input type=\"button\" class=\"btn\" value=\"Setting\" name=\"action-btn\" onclick=\"inlinePopup('#supportsetting','Suppport Ticket Setting');\" />\n            </div>\n-->\n            ";
} else {
    if ($mode == "closeall") {
        $ids = explode("-", $rid);
        foreach ($ids as $i) {
            $s = mysqli_fetch_assoc(dquery("select tid from tbl_support_tickets where id='" . $i . "'"));
            dquery("UPDATE tbl_support_tickets SET sid='2' WHERE tid='" . $s["tid"] . "'");
        }
        echo "<div id=notification1 class=successbox> " . $LNG["ticket"] . " " . $LNG["closed"] . " </div>";
    } else {
        if ($mode == "mergeall") {
            $ids = explode("-", $rid);
            foreach ($ids as $i) {
                $new = $i;
                $tid = mysqli_fetch_assoc(dquery("select tid,subject from tbl_support_tickets where id='" . $new . "'"));
                foreach ($ids as $i) {
                    if ($i != $new) {
                        dquery("UPDATE tbl_support_tickets SET tid='" . $tid["tid"] . "'\n             where id='" . $i . "'");
                    }
                }
                dquery("UPDATE tbl_support_tickets SET subject='" . $tid["subject"] . " [merge]'\n                  where tid='" . $tid["tid"] . "'");
                echo "<div id=notification1 class=successbox> " . $LNG["ticket"] . " " . $LNG["merged"] . " </div>";
            }
        }
    }
    if (!$id || $id == 4) {
        $id = 4;
        $cond = "(sid='4' or sid='1')";
    } else {
        if ($id == 5) {
            $id = 4;
            $cond = "(sid='4')";
        } else {
            $cond = "sid='" . $id . "'";
        }
    }
    if ($uid) {
        $cond .= " and uid='" . $uid . "'";
    }
    if (!$_SESSION["department"]) {
        $_SESSION["department"] = 0;
    }
    $sqmode = mysqli_fetch_assoc(dquery("SELECT @@GLOBAL.sql_mode"));
    if (stripos($sqmode["@@GLOBAL.sql_mode"], "ONLY_FULL_GROUP_BY") !== false) {
        $whereg = "";
    } else {
        $whereg = " group by tid";
    }
    $sql = "SELECT\nid,\nCONCAT('<div style=\"background-color:',(select po.color from tbl_support_priority as po where po.id=pid),';height:13px;width:13px;\"></div>') as color,  \ndate,message,tid,\n(SELECT  cs.department from tbl_support_department as cs where cs.id=did) as department,\nIF(sid=1,'Open',IF(sid=2,'Closed',IF(sid=3,'Answered','Waiting'))) as status,\nCONCAT('<a class=\"\" href=\"javascript: parent.load_page(\\'support.open&edit=',id,'\\',\\'',subject,'\\',\\'\\')\"> ',\nIF(admin_read='',concat('<strong>',subject,'</strong>'),subject)\n,'</a>') as subject,\nDATE_FORMAT(FROM_UNIXTIME(lastreply), '%e %b %Y %h:%i %p') AS 'lastreply',\n(select usf.username from tblUsers as usf where usf.id=uid) as user\nFROM tbl_support_tickets where " . $cond . "  AND did IN (" . $_SESSION["department"] . ") " . $whereg;
    if ($debug_mode) {
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
    $multirow_option = true;
    $dgrid->AllowMultirowOperations($multirow_option);
    $multirow_operations = ["edit" => ["view" => false], "closeall" => ["view" => true, "flag" => "closeall", "flag_value" => "yes", "tooltip" => "Close Ticket"], "mergeall" => ["view" => true, "flag" => "mergeall", "flag_value" => "yes", "tooltip" => "Merge"], "delete" => ["view" => true], "details" => ["view" => false], "Delete Client" => ["view" => false, "flag" => "deleteimeigroup", "flag_value" => "yes", "tooltip" => "Delete Client"]];
    $dgrid->SetMultirowOperations($multirow_operations);
    $http_get_vars = ["page", "accesskey", "uid", "display_errors", "pass", "id"];
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
    if ($_SESSION["department"] == 0) {
        $filtering_option = false;
    } else {
        $filtering_option = true;
    }
    $show_search_type = true;
    $dgrid->AllowFiltering($filtering_option, $show_search_type);
    $fill_from_status = ["1" => "Open", "3" => "Answered", "4" => "Customer-reply", "2" => "Closed"];
    $result = dquery("select department,id from tbl_support_department WHERE id IN (" . $_SESSION["department"] . ")");
    while ($row = mysqli_fetch_assoc($result)) {
        $fill_from_depart[$row["id"]] = $row["department"];
    }
    $result = dquery("select priority,id from tbl_support_priority");
    while ($row = mysqli_fetch_assoc($result)) {
        $fill_from_priority[$row["id"]] = $row["priority"];
    }
    $filtering_fields = ["Ticket ID" => ["type" => "textbox", "shownoresults" => "false", "table" => "tbl_support_tickets", "field" => "tid", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Submitter" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "false", "table" => "tblUsers", "field" => "username", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Department" => ["type" => "dropdownlist", "table" => "tbl_support_tickets", "field" => "did", "field_view" => "did", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_depart, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Priority" => ["type" => "dropdownlist", "table" => "tbl_support_tickets", "field" => "pid", "field_view" => "pid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_priority, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_support_tickets", "field" => "date", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tbl_support_tickets", "field" => "date", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "on_js_event" => ""]];
    $dgrid->SetFieldsFiltering($filtering_fields);
    $vm_table_properties = ["width" => "100%"];
    $dgrid->SetViewModeTableProperties($vm_table_properties);
    $vm_colimns = ["tid" => ["header" => "#ID", "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal", "unique" => true], "color" => ["header" => (string) $LNG["priority"], "type" => "label", "align" => "left", "wrap" => "wrap", "text_length" => "-1", "case" => "normal"], "date" => ["header" => (string) $LNG["date"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "department" => ["header" => (string) $LNG["department"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "subject" => ["header" => (string) $LNG["subject"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "user" => ["header" => (string) $LNG["user"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "status" => ["header" => (string) $LNG["status"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "lastreply" => ["header" => (string) $LNG["lastreply"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"]];
    $dgrid->SetColumnsInViewMode($vm_colimns);
    $em_table_properties = ["width" => "75%"];
    $dgrid->SetEditModeTableProperties($em_table_properties);
    $dm_table_properties = ["width" => "60%"];
    $dgrid->SetDetailsModeTableProperties($dm_table_properties);
    $table_name = "tbl_support_tickets";
    $primary_key = "id";
    $condition = "";
    $dgrid->SetTableEdit($table_name, $primary_key, $condition);
    $dgrid->WriteCssClass();
    $dgrid->Bind();
}
if ($_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    echo "</div>";
}
echo "        ";
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Support/?aid=37&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
echo "    </div>\n";
$fileverioncheck = "6.1.0";

?>