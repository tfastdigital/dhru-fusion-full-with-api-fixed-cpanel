<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 332;
checkPagePermission($pageid);
if (!$l || $p) {
    echo "<ul id=\"tabmenu\">\n <li><a class='tabmenu_active' onclick=\"getContect('#tab1','main2.php?page=utilities.adminactivities&l=1','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["admin"];
    echo " ";
    echo $LNG["login"];
    echo " ";
    echo $LNG["log"];
    echo "</a></li>\n <li><a onclick=\"getContect('#tab2','main2.php?page=utilities.useractivities&l=1','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["user"];
    echo " ";
    echo $LNG["login"];
    echo " ";
    echo $LNG["log"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>  \n<div id=\"tabcontent\">\n";
}

$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_loginlog_admin");
    $users = $stmt->fetchAll();
   


?>
<link rel="stylesheet" type="text/css" href="/datatables/jquery.dataTables.min.css">
<script type="text/javascript" language="javascript" src="/datatables/jquery.dataTables.min.js"></script>
<script>$(document).ready(function () {
    $('#example').DataTable();
});</script>
<table id="example" class="display" style="width:100%">
        <thead>
            
Username	E-Mail	Login From	Login Time	IP
            
            <tr>
                <th>Username</th>
                <th>E-Mail</th>
                 <th>Login From</th>
                  <th>Login Time</th>
                   <th>IP</th>
                    
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>

                <td><?=$user['username']?></td>
                <td><?=$user['date']?></td>
                <td>admin</td>
                <td><?=$user['time']?></td>
                <td><?=$user['ip']?></td>
           
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>