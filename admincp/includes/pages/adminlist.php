<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($p || $_GET["_ff_onSUBMIT_FILTER"] == "Search") {
    include "admin.head.php";
    echo "<div id=\"tabcontent\">\n";
}
$pageid = 299;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
if ($deleteimeigroup) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        if ($val == "1") {
            $error = "<li>" . $LNG["cannotdeletethisadmin"] . "</li>";
        } else {
            if (dquery("delete from tbl_admin where id=" . $val)) {
                $success = $LNG["admin"] . " " . $LNG["deleted"] . " " . $LNG["successfully"];
            }
        }
    }
}
if ($error) {
    echo "<div id=notification1 class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification1 class=successbox>" . $success . "</div>";
}
$sql = "SELECT tbl_admin.id,\nCONCAT('<a class=\\'default_dg_a\\' \nonclick=\"load_subpage(\\'main2.php?page=editadmin&admn=',tbl_admin.id,'\\',\\'Edit Admin\\');\">',tbl_admin.username,'</a>') as username,\nif( tbl_admin.status = '0', '" . $img_green . "', '" . $img_red . "' ) AS flags, \nCONCAT( '<a class=\\'default_dg_a2 editdata\\' \nonclick=\"load_subpage(\\'main2.php?page=editadmin&admn=',tbl_admin.id,'\\',\\'Edit Admin\\');\">Edit</a>' )  AS action_links, \nCONCAT( '<a class=\\'default_dg_a\\' href=\"javascript:redirectedit(\\'editadminaccessgroup\\', ', tbl_admin_access_group.id,')\">',group_name,'</a>' )  AS group_name,\ntbl_admin_access_group.id as groupID,\nIF(credit='','Unlimited',credit) as credit\nFROM tbl_admin\nLEFT OUTER JOIN tbl_admin_access_group ON tbl_admin_access_group.id = tbl_admin.group_id\n";
if ($debug_output) {
    $debug_mode = true;
} else {
    $debug_mode = false;
}
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_admin");
    $users = $stmt->fetchAll();
   


?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
        <thead>

	ID	Username	Group Name	Flag	Add Fund Limit	Actions

            
            <tr>
                <th>ID</th>
                <th>Username</th>
                
               <th>Duzenle</th>
                
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
             
                
                 <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editadmin&admn=<?=$user['id']?>">Düzenle</a></td>
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>