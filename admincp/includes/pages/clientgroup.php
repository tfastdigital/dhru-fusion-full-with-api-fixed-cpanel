<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"tabcontent\">\n<style>\n.default_dg_error_message{\n    display:none;\n}\n</style>\n<script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n<script>\n    \$(document).ready(function() {\n        \$('.default_dg_table').tableDnD({\n            onDrop: function(table, row) {\n                var serialized= \$.tableDnD.serialize();\n                \$.ajax({\n                    type: 'POST',\n                    url: \"includes/pages/clientgroup.order.save.php\",\n                    data: serialized,\n                    success: function(data) {\n                       location.reload();\n                    }\n                });\n            }\n        });\n    });\n</script>\n    ";
include "client.head.php";

$pageid = 402;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
if ($action == "cs" && $gid) {
    dquery("update tbl_client_group set showon=if(showon=1,0,1) where\n   id='" . $gid . "'");
}
$val = dquery("select 1 from `tbl_membership_fee`");
if ($val === false) {
    dquery("CREATE TABLE IF NOT EXISTS `tbl_membership_fee` (      `id` int(11) NOT NULL AUTO_INCREMENT,      `gid` int(11) NOT NULL,      `cid` int(11) NOT NULL,      `fee` varchar(50) NOT NULL,      PRIMARY KEY (`id`)    ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
    dquery("alter table tbl_client_group add fee varchar(15),add days int(5),add `type` int(1)");
    dquery("alter table tblUsers add group_start  varchar(50),add group_end varchar(50)");
    dquery("INSERT INTO `tbl_emailtemplates` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`) VALUES    (74, 'general', 'Group subscription expiry reminder', 'Your subscription expired on {\$date}', 'Dear {\$username}Your subscription for {\$group} expired on {\$date}', '', '', '', '', '', '', 1, 0, '', 0)");
    dquery("INSERT INTO `tbl_emailtemplates_backup` (`id`, `type`, `name`, `subject`, `message`, `fromname`, `fromemail`, `disabled`, `custom`, `language`, `copyto`, `plaintext`, `for_reseller`, `template_variable`, `newsletter_default`) VALUES    (74, 'general', 'Group subscription expiry reminder', 'Your subscription expired on {\$date}', 'Dear {\$username}Your subscription for {\$group} expired on {\$date}', '', '', '', '', '', '', 1, 0, '', 0)");
}
if (isset($_GET["rid"])) {
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_discount_imei where userid in ( select id \n            from tblUsers where client_group='" . $d . "')");
            dquery("DELETE FROM tbl_discount_file where userid in ( select id \n            from tblUsers where client_group='" . $d . "')");
            dquery("DELETE FROM tbl_discount_server_log where userid in ( select id \n            from tblUsers where client_group='" . $d . "')");
            dquery("UPDATE tblUsers set client_group='0',imei_services='ALL'\n             ,file_servies='ALL',server_logs='ALL',newserver_services='ALL',imei_service_access=1,file_service_access=1,\n             server_log_access=1 where client_group='" . $d . "')");
            dquery("DELETE FROM tbl_client_group WHERE id='" . $d . "'");
            dquery("DELETE FROM tbl_client_group_price where group_id='" . $d . "'");
        }
        echo "<div id='notification1' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
echo "\n<div id=\"notification\"></div>\n\n<div  class=\"groupstabes\" >\n\n  <div class=\"groupstabescontant\">\n\n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>\n    <span class=\"groupstabesheadertext\">Add Client Group</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["group"];
echo "</td>\n    <td class=\"fieldarea\"><input type=\"text\" name=\"group\" /> </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        <lable><input type=\"checkbox\" name=\"allservice\"> Enable for All Services</lable>\n    </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n        <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"addFromgallery\" type=\"button\"\n               onclick=\"SubmitForm ('#btnaddgroup','clientgroup','#frm','#notification','true','#main_loader','main2.php?page=clientgroup');\"/>\n    </td>\n</tr>\n</tbody>\n</table>\n</form>\n\n\n</div></div></div></div>\n\n ";
if (!$OnlyEcommerce) {
    $sql = "SELECT  tbl_client_group.id, tbl_client_group.groupname ,\n    CONCAT('<a class=\\'default_dg_a2\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editclientgroup&id=',tbl_client_group.id,'\\',\\'Edit\\');    return false;\" >',tbl_client_group.groupname,'</a>') as `groups`\n    ,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'editclientgroup&id=',id,'\\',\\'Edit Client Group ',id,'\\')\">" . $LNG["edit"] . "</a>')\n\nas viewstatus\n    \n    ,\n    CONCAT('<a class=\\'default_dg_a2\\' href=\"javascript:load_subpage(\\'main2.php?page=clientgroupmember&id=',tbl_client_group.id,'\\',\\'" . $LNG["member"] . "\\')\" >" . $LNG["member"] . "</a>',\n    '&nbsp; &nbsp;&nbsp;','<a class=\\'default_dg_a2\\' href=\"javascript:load_subpage(\\'main2.php?page=clientgroupgateway&id=',tbl_client_group.id,'\\',\\'" . $LNG["payment"] . " " . $LNG["gateway"] . "\\')\" >" . $LNG["payment"] . " " . $LNG["gateway"] . "</a>') as action_links\nFROM tbl_client_group where 1=1 ";
} else {
    $sql = "SELECT  tbl_client_group.id, tbl_client_group.groupname ,\n    CONCAT('<a class=\\'default_dg_a2\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'main2.php?page=editclientgroup&id=',tbl_client_group.id,'\\',\\'Edit\\');    return false;\" >',tbl_client_group.groupname,'</a>') as `groups`\n    ,\n    CONCAT('',\n    '&nbsp;&nbsp;&nbsp;','<a class=\\'default_dg_a2\\' href=\"javascript:load_subpage(\\'main2.php?page=clientgroupmember&id=',tbl_client_group.id,'\\',\\'" . $LNG["member"] . "\\')\" >" . $LNG["member"] . "</a>') as action_links\nFROM tbl_client_group where 1=1 ";
}
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
    $stmt = $pdo->query("SELECT * FROM tbl_client_group");
    $users = $stmt->fetchAll();
   


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
                <th>Client Group Name </th>
                <th>	Actions</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['groupname']?></td>
                <td><?=$user['paymentgateway']?></td>
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editclientgroup&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php


