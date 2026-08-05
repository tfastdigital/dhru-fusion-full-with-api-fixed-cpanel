<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include_once DATAGRID_DIR2 . "comm.php";
include_once "includes/comm.inc.php";
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM 	tbl_services_imei");
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
                <th>Service</th>
                <th>Date</th>
                <th>Mail</th>
                  <th>QNT</th>
                   <th>Service</th>
               
                  
                   <th>Edit</th>
                    
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>

                <td><?=$user['service_name']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['notification_mail']?></td>
                <td><?=$user['qnt']?></td>
               
                   
                <td><?=$user['ip']?></td>
           
           
           <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editebayorder&id=<?=$user['id']?>">Düzenle</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>