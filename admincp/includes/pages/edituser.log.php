<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
if ($_REQUEST["_ff_onSUBMIT_FILTER"] == "Search") {
    include "edituser.head.php";
}
echo "<div id=\"tabcontent\">\n";
$pageid = 331;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
include_once "includes/comm.inc.php";
$sql = "SELECT tbl_loginlog_user.username as loginfrom,\nCONCAT('<a target=\"_blank\" href=\"" . $config["ip_location"] . "',ip,'\">',tbl_loginlog_user.ip,'</a>') as ip,\n time \nFROM `tbl_loginlog_user` \nwhere tbl_loginlog_user.userid='" . $id . "'";
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
    $stmt = $pdo->query("SELECT * FROM tbl_loginlog_user");
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
                <th>Login From</th>
                <th>Login Time</th>
                <th>IP</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['ip']?></td>
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" target="_blank"href="https://geo.dhru.com/?ip=<?=$user['ip']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>