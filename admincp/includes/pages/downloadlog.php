<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Download Log</a></li>\n</ul>\n";
if (!$_SESSION["adminid"]) {
    exit("error:invalid token");
}
include DATAGRID_DIR2 . "comm.php";
$sql = "SELECT\nid,ip,username,time,(select filename from tbl_download where id=did) as file\nFROM tbl_download_log WHERE 1=1";
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
    $stmt = $pdo->query("SELECT * FROM tbl_download");
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
                <th>ip</th>
                <th>username</th>
                <th>time</th>
               <th>did</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['ip']?></td>
                <td><?=$user['username']?></td>
                <td><?=$user['time']?></td>
                <td><?=$user['did']?></td>
    
              
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>