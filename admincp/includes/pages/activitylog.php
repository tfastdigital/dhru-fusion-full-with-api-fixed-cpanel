<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 546;
checkPagePermission($pageid);
if (($_ff_onSUBMIT_FILTER == "Search" || $cancelinvoice || $p) && $reports != 1) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
echo "\n\n";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
include_once DATAGRID_DIR2 . "comm.php";
$sql = "SELECT\ndate,CONCAT('<textarea>',description,'</textarea>') as description,\ntype,(select username from tbl_admin where id=eventby) as eventby,\n(select username from tblUsers where id=eventon) as eventon\n,\n CONCAT('<a href=\"javascript: load_subpage(\\'" . $config["ip_location"] . "',ip,'\\',\\'" . $LNG["ip"] . " " . $LNG["location"] . "\\')\">',ip,'</a>') as ip\n FROM tbl_activity_log WHERE 1=1";
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
    $stmt = $pdo->query("SELECT * FROM tbl_activity_log");
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
                <th>date</th>
                <th>description</th>
                <th>type</th>
               <th>eventon</th>
                 <th>eventby</th>
                   <th>user</th>
                    <th>ip</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['description']?></td>
                <td><?=$user['type']?></td>
                <td><?=$user['eventon']?></td>
                 <td><?=$user['eventby']?></td>
                <td><?=$user['user']?></td>
                <td><?=$user['ip']?></td>
    
              
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>