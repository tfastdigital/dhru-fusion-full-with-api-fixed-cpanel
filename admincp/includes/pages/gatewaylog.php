<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Gateway Log</a></li>\n</ul>\n";
$pageid = 424;
checkPagePermission($pageid);
include DATAGRID_DIR . "comm.php";
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_gatewaylog");
    $users = $stmt->fetchAll();
   


?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
        <thead>
id	date	gateway	data	result	type	relid	userid	refid


            
            <tr>
                <th>ID</th>
                <th>date</th>
                <th>gateway</th>
                <th>data</th>
               <th>result</th>
                 <th>type</th>
                   <th>relid</th>
                    <th>userid</th>
                    <th>refid</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['gateway']?></td>
                <td><?=$user['data']?></td>
                <td><?=$user['result']?></td>
                 <td><?=$user['type']?></td>
                <td><?=$user['relid']?></td>
                <td><?=$user['userid']?></td>
    
              
               <td><?=$user['refid']?></td>
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>