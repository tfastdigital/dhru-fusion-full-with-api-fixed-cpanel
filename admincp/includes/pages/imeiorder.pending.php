<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 506;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
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
i
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_order_imei");
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
                <th>Date</th>
                 <th>Completed In</th>
                  <th>Service	API</th>
                   <th>Username</th>
                    <th>IMEI</th>
                     <th>Status</th>
                <th>Düzenle</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['status']?></td>
                <td><?=$user['service_id']?></td>
                <td><?=$user['user_id']?></td>
                <td><?=$user['imei']?></td>
                <td><?=$user['status']?></td>
                
               
                
                
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=edituser.editinvoice&id=<?=$user['id']?>">Düzenle</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>