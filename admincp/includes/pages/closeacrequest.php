<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\r\n";
$pageid = 482;
checkPagePermission($pageid);
global $adminAddPayment;
$adminAddPayment = true;
include_once DATAGRID_DIR2 . "comm.php";
include_once "includes/comm.inc.php";
$sql = "SELECT *,\r\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser&id=',tblUsers.id,'\\',\\'  ',tblUsers.username,'\\')\">" . $LNG["edit"] . "</a>') as actions\r\nFROM `tblUsers` WHERE closeac='1'";
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
    $stmt = $pdo->query("SELECT * FROM tblUsers");
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
                <th>Username</th>
                <th>E-Mail</th>
              <!-- <th>Duzenle</th> -->
                
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
                 <!--<td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editadmin&admn=<?=$user['id']?>">Düzenle</a></td> -->
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>