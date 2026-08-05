<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Newsletter Subscriber</a></li>\n</ul>\n";
$pageid = 477;
checkPagePermission($pageid);
echo "<div id=\"content\">\n\n    <div  class=\"groupstabes\" style=\"float: left;width:49%\">\n        <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
echo $LNG["email"] . " " . $LNG["list"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n        </h2>\n        <div class=\"groupstabescontant\">\n\n            <form id=\"frm\" name=\"\" method=\"post\">\n                ";
echo generate_token("form");
echo "                <table>\n                    <tr>\n                        <td class=\"fieldarea\"><span>\n  <textarea name='list' rows='5' cols=\"50\"></textarea><small>";
echo $LNG["emailnewline"];
echo "</small>\n    </span></td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldarea\"><span>\n    <input type=\"submit\" name=\"save\" class='btn save'  value='Import' />  </span></td>\n                    </tr>\n                </table>\n            </form>\n        </div></div>\n\n\n\n    <div  class=\"groupstabes\" style=\"float: right;width: 49%;\">\n        <h2>\n            <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n            <span class=\"groupstabesheadertext\">";
echo $LNG["upload"] . " " . $LNG["from"] . " csv " . $LNG["file"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n        </h2>\n        <div class=\"groupstabescontant\">\n\n            <form method=\"post\" enctype=\"multipart/form-data\">\n                <table>\n                    <tr>\n                        <td class=\"fieldarea\" align=\"left\"><input type=\"file\" name=\"csv\" /></td>\n                    </tr>\n                    <tr>\n                        <td align=\"left\" >\n                            e.g.<br />\n                            <textarea readonly=\"\" cols=\"50\">\"test@gmail.com\",\"John Smith\" \"test@yahoo.com\",\"Loren Ipsum\" \"test@hotmail.com\",\"\" </textarea>\n                            <br /><small>CSV File format example - \"Email(Compulsory)\",\"Name(optoinal)\"</small> </td>\n                    </tr>\n                    <tr>\n                        <td class=\"fieldarea\"><span>\n<input type=\"submit\" class=\"btn save\" name=\"import\" value=\"Import\" />\n    </span></td>\n                    </tr>\n                </table>\n            </form>\n        </div></div>\n    <div class=\"clear\"></div>\n</div>\n";
if ($id) {
    dquery("UPDATE tbl_newsletter set active=IF(active=1,0,1) WHERE id='" . $id . "'");
}
if ($save) {
    $list = explode("\n", $list);
    foreach ($list as $l) {
        $l = trim($l);
        if ($l) {
            $l = explode(" ", $l);
            $sql = dquery("select id from tbl_newsletter where email='" . $l[0] . "'");
            $email = trim($l[0]);
            if (preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email) && !mysqli_num_rows($sql)) {
                $data = NULL;
                $data["email"] = $email;
                $data["name"] = $l[1];
                $data["active"] = 1;
                $data["time"] = time();
                $data["IP"] = $_SERVER["REMOTE_ADDR"];
                $db->insert("tbl_newsletter", $data);
            }
        }
    }
}
if ($import) {
    if ($_FILES["csv"]["error"] <= 0) {
        $row = 0;
        $skip = 0;
        $arr = [];
        if (($handle = fopen($_FILES["csv"]["tmp_name"], "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if (count($data) == 2 && $data[0] != "") {
                    $flag = true;
                    $sql = dquery("select id from tbl_newsletter where email='" . $data[0] . "'");
                    $email = trim($data[0]);
                    if (preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $email) && !mysqli_num_rows($sql)) {
                        $datas = NULL;
                        $datas["email"] = $email;
                        $datas["name"] = $data[1];
                        $datas["active"] = 1;
                        $datas["time"] = time();
                        $datas["IP"] = $_SERVER["REMOTE_ADDR"];
                        $db->insert("tbl_newsletter", $datas);
                        $datas = NULL;
                        $row++;
                    }
                } else {
                    $skip++;
                }
            }
        }
        fclose($handle);
        if ($flag) {
            echo "<div id='notification1' class='successbox'>" . $row . " - Email imported successfully\n            <br />\n            " . $skip . " - Email skipped\n            </div>";
        } else {
            echo "<div id='notification1' class='errorbox'>Invalid File format</div>";
        }
    } else {
        echo "<div id='notification1' class='errorbox'>Error in file import</div>";
    }
}
if ($mode == "active") {
    $rid = explode("-", $rid);
    foreach ($rid as $r) {
        dquery("UPDATE tbl_newsletter set active='1' WHERE id='" . $r . "'");
    }
}
if ($mode == "inactive") {
    $rid = explode("-", $rid);
    foreach ($rid as $r) {
        dquery("UPDATE tbl_newsletter set active='0' WHERE id='" . $r . "'");
    }
}
include DATAGRID_DIR . "comm.php";
if ($filter) {
    $where = " and email like '" . $filter . "'";
}
$sql = "SELECT\ntbl_newsletter.id,\ntbl_newsletter.email,\nCONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\">',tbl_newsletter.ip,'</a>') AS ip,\ntbl_newsletter.active,\nDATE( FROM_UNIXTIME( tbl_newsletter.time) ) AS time ,\nCONCAT('<a class=\\'default_dg_a2\\' href=\\'javascript:reloadcurrent(\"newsletter\",\"',tbl_newsletter.id,'\")\\'>',IF(active=1,\"Active\",\"Inactive\"),'</a>') AS action\nFROM tbl_newsletter WHERE 1=1 " . $where;
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
$multirow_option = true;
$dgrid->AllowMultirowOperations($multirow_option);
$multirow_operations = ["edit" => ["view" => false], "details" => ["view" => false], "delete" => ["view" => true], "active" => ["view" => true, "flag_name" => "Active", "flag_value" => "Active", "tooltip" => "Active"], "inactive" => ["view" => true, "flag_name" => "Inactive", "flag_value" => "Inactive", "tooltip" => "Inactive"]];
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
$default_page_size = 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];
$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size, $paging_arrows);
$filtering_option = true;
$show_search_type = true;
$dgrid->AllowFiltering($filtering_option, $show_search_type);
$fill_from_admin = $admin;
$fill_from_discription = $discription;
$arr = ["1" => "Active", "0" => "Inactive"];
$filtering_fields = ["Email" => ["type" => "textarea", "maxresults" => "10", "shownoresults" => "false", "table" => "tbl_newsletter", "field" => "email", "show_operator" => "false", "default_operator" => "in", "case_sensitive" => "false", "comparison_type" => "string", "hint" => "Each Email by New Line", "width" => "420px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tbl_newsletter", "field" => "active", "field_view" => "active", "filter_condition" => "", "order" => "ASC", "source" => $arr, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];
$dgrid->SetFieldsFiltering($filtering_fields);
$vm_table_properties = ["width" => "100%"];
$dgrid->SetViewModeTableProperties($vm_table_properties);
$vm_colimns = ["email" => ["header" => (string) $LNG["email"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "-1", "case" => "normal"], "time" => ["header" => (string) $LNG["regidate"], "type" => "textarea", "align" => "left", "wrap" => "nowrap", "text_length" => "30", "case" => "normal"], "ip" => ["header" => (string) $LNG["ip"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"], "action" => ["header" => (string) $LNG["action"], "type" => "label", "align" => "left", "wrap" => "nowrap", "text_length" => "555", "case" => "normal"]];
$dgrid->SetColumnsInViewMode($vm_colimns);
$em_table_properties = ["width" => "75%"];
$dgrid->SetEditModeTableProperties($em_table_properties);
$dm_table_properties = ["width" => "60%"];
$dgrid->SetDetailsModeTableProperties($dm_table_properties);
$table_name = "tbl_newsletter";
$primary_key = "id";
$condition = "";
$dgrid->SetTableEdit($table_name, $primary_key, $condition);
$dgrid->WriteCssClass();
$dgrid->Bind();
$fileverioncheck = "6.1.0";

?>