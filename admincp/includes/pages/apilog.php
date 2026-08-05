<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">APi Log</a></li>\n</ul>\n";
$pageid = 423;
checkPagePermission($pageid);
include DATAGRID_DIR2 . "comm.php";
if ($id) {
    $where = " and id='" . $id . "'";
}
$sql = "SELECT\ntbl_apilog.id,\ntbl_apilog.date,\ntbl_apilog.gateway,\nCONCAT('<textarea rows=\"3\" cols=\"50\" readonly=\"readonly\">',data,'</textarea>') as data,\ntbl_apilog.result\nFROM tbl_apilog WHERE 1=1 " . $where . "\n";
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
    $stmt = $pdo->query("SELECT * FROM tbl_apilog");
    $users = $stmt->fetchAll();
   


?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
        <thead>

id	date	gateway	data	result	orderid	apiserviceid	send	connections

            
            <tr>
                <th>ID</th>
                <th>date</th>
                <th>gateway</th>
                <th>data</th>
               <th>result</th>
                 <th>orderid</th>
                   <th>apiserviceid</th>
                    <th>send</th>
                    <th>connections</th>
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
                 <td><?=$user['orderid']?></td>
                <td><?=$user['apiserviceid']?></td>
                <td><?=$user['send']?></td>
    
              
               <td><?=$user['connections']?></td>
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>