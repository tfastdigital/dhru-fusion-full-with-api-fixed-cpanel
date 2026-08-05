<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<style>\n    .default_dg_table thead tr th:last-child, #main_tbl thead tr th:last-child {\n        width: auto !important;\n    }\n</style>\n<div id=\"tabcontent\">\n\n";
include "supplier.head.php";
echo "<style>\n    .imei,.file,.server,.shop{height:15px;width:15px;float: left;margin:3px}\n    .imei{background: #F0AA65;}\n    .file{background: #c4bfd9;}\n    .server{background: #90c0db;}\n    .shop{background: #a4cc8a;}\n    .default_dg_table thead tr th:last-child, #main_tbl thead tr th:last-child{width:auto}\n</style>\n";
licince\chkLitePlus();
licince\chklite();
$pageid = 285;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";

$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_supplier");
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
                  <th>E-Access</th>
                <th>Düzenle</th>
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
                <td><?=$user['access_key']?></td>
             
       
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editsupplier&id=<?=$user['id']?>">Düzenle</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>