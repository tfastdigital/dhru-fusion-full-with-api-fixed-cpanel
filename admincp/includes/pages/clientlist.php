<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($_REQUEST["_ff_onSUBMIT_FILTER"] == "Search" && $id) {
    include "edituser.head.php";
}
echo "<div id=\"tabcontent\"><div title=\"clientlist\" id=\"tutid\"></div>\n    ";
if (!$reseller) {
    include "client.head.php";
}
$pageid = 255;
checkPagePermission($pageid);
if ($id) {
    if ($id == "active") {
        $where = "where userstatus=0 and guest=0";
    } else {
        if ($id == "inactive") {
            $where = "where (userstatus=1 or userstatus=2) and guest=0";
        }
    }
} else {
    $where = "where  guest=0";
}
if ($checkoverdrive) {
    $where .= " and allowoverdrive>0";
}
if ($reseller) {
    if (!$where) {
        $where .= " where reseller_id='" . $reseller . "'";
    } else {
        $where .= " and reseller_id='" . $reseller . "'";
    }
}
if ($_ff_tblUsers_last_login) {
    $_GET["_ff_tblUsers_last_login"] = time(date("Y-m-d", strtotime("-" . $_ff_tblUsers_last_login . " days")));
    $where .= " and last_login!=''";
}
include_once DATAGRID_DIR2 . "comm.php";
if ($mode == "Active") {
    $e = explode("-", $rid);
    foreach ($e as $d) {
        dquery("update tblUsers set userstatus='0' WHERE id='" . $d . "'");
    }
    echo "<div class='successbox' id='notification1'>Account activated successfully </div>";
}
if ($mode == "Inactive") {
    $e = explode("-", $rid);
    foreach ($e as $d) {
        dquery("update tblUsers set userstatus='1' WHERE id='" . $d . "'");
    }
    echo "<div class='successbox' id='notification1'>Account inactivated successfully </div>";
}
$sql = "SELECTtblUsers.id,  DATE_FORMAT(FROM_UNIXTIME(`ac_create_dt`), '%Y-%m-%d %h:%i %p') AS 'regdate',CONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',tblUsers.id,'\\',\\' ',tblUsers.username,'\\')\">',username,(if((select status from tbl_document where uid=tblUsers.id)=1,' <span class=\"textgreen\">[KYC]</span>','')),'</a>' )  AS username,  CONCAT( '',tblUsers.email,'' )  AS email,CONCAT(IF(tblUsers.credit_left < 100,CONCAT('<span class=textred>',round(tblUsers.credit_left," . $precision . "),'</span>'),CONCAT('<span>',round(tblUsers.credit_left," . $precision . "),'</span>')),' ',(select code from tbl_currencies where tbl_currencies.id=tblUsers.default_currency)) as credit_left, \ntblUsers.credit_used,\ntblUsers.userstatus,\nCONCAT(if( tblUsers.userstatus = '0', '<img src=\"images/green.gif\" title=\"Account is fully Activeted\">',if(tblUsers.userstatus = '2' and tblUsers.is_registered = '0','<img src=\"images/blue.gif\" title=\"New register Users\">','<img src=\"images/red.gif\" title=\"Account is inactive for some reason or blocked\">')) ,'&nbsp;&nbsp;', if( tblUsers.usertype = '0', '" . $img_trans . "',if(tblUsers.usertype = '1','<img src=\"images/black.gif\" title=\"Advance Reseller\">','<img src=\"images/gray.gif\" title=\"Resellers Users\">')) ,'&nbsp;&nbsp;', if(DATEDIFF(CURDATE(),FROM_UNIXTIME(last_login)) > 30,'<img src=\"images/yellow.gif\" title=\"Not Login Since Last 30 Days\">','" . $img_trans . "')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',tblUsers.id,'\\',\\'  ',tblUsers.username,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM tblUsers " . $where;
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = true;
}



$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tblUsers");
    $users = $stmt->fetchAll();
   

$messaging = true;
$unique_prefix = "";

$default_order_field = "id";
$default_order_type = "ASC";

$ajax_option = true;

$layouts = ["edit" => "0", "details" => "0", "filter" => "1"];

$modes = ["add" => ["view" => false, "edit" => false, "type" => "link", "show_add_button" => "inside|outside"], "edit" => ["view" => false, "edit" => false, "type" => "link", "byFieldValue" => ""], "cancel" => ["view" => false, "edit" => true, "type" => "link"], "details" => ["view" => false, "edit" => false, "type" => "link"], "delete" => ["view" => false, "edit" => true, "type" => "image"]];

$multirow_option = true;

$multirow_operations = ["edit" => ["view" => false], "delete" => ["view" => false], "details" => ["view" => false], "Active" => ["view" => true, "flag_name" => "Active", "flag_value" => "yes", "tooltip" => "Active"], "Inactive" => ["view" => true, "flag_name" => "Inactive", "flag_value" => "yes", "tooltip" => "Inactive"]];

if ($reseller) {
    $http_get_vars = ["page", "accesskey", "display_errors", "pass", "reseller", "checkoverdrive"];
} else {
    $http_get_vars = ["page", "accesskey", "display_errors", "pass"];
}

$dg_caption = "";

$printing_option = true;

$exporting_option = true;
$exporting_directory = "tmp/";

$exporting_types = ["excel" => "true", "pdf" => "true", "xml" => "true"];

$paging_option = true;
$rows_numeration = false;
$numeration_sign = "N #";
$dropdown_paging = true;

$bottom_paging = ["results" => true, "results_align" => "left", "pages" => true, "pages_align" => "center", "page_size" => true, "page_size_align" => "right"];
$top_paging = [];
$pages_array = ["5" => "5", "10" => "10", "25" => "25", "50" => "50", "100" => "100", "250" => "250", "500" => "500", "1000" => "1000"];
if ($config["adminlistlimit"] && !in_array($config["adminlistlimit"], $pages_array)) {
    $pages_array[$config["adminlistlimit"]] = $config["adminlistlimit"];
}
$default_page_size = $config["adminlistlimit"] ? $config["adminlistlimit"] : 10;
$paging_arrows = ["first" => "|&lt;&lt;", "previous" => "&lt;&lt;", "next" => "&gt;&gt;", "last" => "&gt;&gt;|"];

$filtering_option = true;
$show_search_type = true;

$fill_from_status = ["Active", "Block", "Inactive"];
$fill_from_user_type = ["User", "Reseller", "3" => "Reseller's User"];
$result = dquery("select code,id from tbl_currencies");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_currency[$row["id"]] = $row["code"];
}
$result = dquery("select username,id from tblUsers where usertype=1");
while ($row = mysqli_fetch_assoc($result)) {
    $fill_from_reseller[$row["id"]] = $row["username"];
}
$fill_from_group[0] = "Default";
$cl = dquery("select * from tbl_client_group order by displayorder asc");
while ($rd = mysqli_fetch_assoc($cl)) {
    $fill_from_group[$rd["id"]] = $rd["groupname"];
}
$fill_from_tele[0] = "Yes";
include_once ROOTDIR . "/includes/countries.php";
$filter_country = $countries;
$filter_api = ["1" => "Enabled", "0" => "Disabled"];
$overd = ["1" => "Overdrive"];
$newsl = ["1" => "Enabled"];
$fill_signup = ["" => "Normal signup", "quick" => "Quick Checkout", "direct" => "Direct Order"];
$filtering_fields = ["Name" => ["type" => "textbox", "autocomplete" => "true", "handler" => "../../autosuggest/clientlist.name.php", "maxresults" => "10", "shownoresults" => "true", "table" => "tblUsers", "field" => "username", "show_operator" => "true", "default_operator" => "like%", "case_sensitive" => "true", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Email" => ["type" => "textbox", "maxresults" => "10", "shownoresults" => "true", "table" => "tblUsers", "field" => "email", "show_operator" => "false", "default_operator" => "like%", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Status" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "userstatus", "field_view" => "userstatus", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_status, "condition" => "", "show_operator" => "true", "default_operator" => "=", "case_sensitive" => "true", "comparison_type" => "string", "width" => "", "multiple" => "true", "multiple_size" => "4", "on_js_event" => ""], "Overdrive" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "allowoverdrive", "field_view" => "allowoverdrive", "filter_condition" => "", "order" => "ASC", "source" => $overd, "condition" => "", "show_operator" => "true", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Newsletter" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "news_letter", "field_view" => "news_letter", "filter_condition" => "", "order" => "ASC", "source" => $newsl, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "API" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "api_access", "field_view" => "api_access", "filter_condition" => "", "order" => "ASC", "source" => $filter_api, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Country" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "country", "field_view" => "country", "filter_condition" => "", "order" => "ASC", "source" => $filter_country, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Client Group" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "client_group", "field_view" => "client_group", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_group, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Singup From" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "signupby", "field_view" => "signupby", "filter_condition" => "", "order" => "ASC", "source" => $fill_signup, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "User Type" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "usertype", "field_view" => "usertype", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_user_type, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Reseller" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "reseller_id", "field_view" => "reseller_id", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_reseller, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Currency" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "default_currency", "field_view" => "default_currency", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_currency, "condition" => "", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""], "Credit Equal To " => ["type" => "textbox", "table" => "tblUsers", "field" => "credit_left", "show_operator" => "false", "default_operator" => "=", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Credit Greater Than " => ["type" => "textbox", "table" => "tblUsers", "field" => "credit_left", "show_operator" => "false", "default_operator" => ">", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "Not Login From Days" => ["type" => "textbox", "table" => "tblUsers", "field" => "last_login", "show_operator" => "false", "default_operator" => "<", "case_sensitive" => "false", "comparison_type" => "string", "width" => "220px", "on_js_event" => ""], "From Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tblUsers", "field" => "ac_create_dt", "filter_condition" => "", "field_type" => "from", "show_operator" => "false", "default_operator" => ">=", "case_sensitive" => "false", "comparison_type" => "timestamp", "width" => "", "on_js_event" => ""], "To Date" => ["type" => "calendar", "calendar_type" => "floating", "date_format" => "date", "table" => "tblUsers", "field" => "ac_create_dt", "filter_condition" => "", "field_type" => "to", "show_operator" => "false", "default_operator" => "<=", "case_sensitive" => "false", "comparison_type" => "timestamp", "width" => "", "on_js_event" => ""], "Telegram Bot Connected" => ["type" => "dropdownlist", "table" => "tblUsers", "field" => "messengerid", "field_view" => "messengerid", "filter_condition" => "", "order" => "ASC", "source" => $fill_from_tele, "condition" => "", "show_operator" => "false", "default_operator" => ">", "case_sensitive" => "false", "comparison_type" => "string", "width" => "", "multiple" => "false", "multiple_size" => "4", "on_js_event" => ""]];



?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>E-Mail</th>
                <th>Available Balance</th>
                <th> Client Group İd</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['email']?></td>
                <td><?=$user['credit_left']?></td>
                 <td><?=$user['client_group']?></td>
                
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=edituser&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
            
    <?php
}

?>
        </tbody>
    </table>
<?php









?>