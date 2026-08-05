<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!$p2) {
    include "blog.head.php";
    echo "     <div id=\"tabcontent\">\n";
}

    $pageid = 208;
    checkPagePermission($pageid);
$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_blogposts");
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
                <th>cat</th>
                <th>title</th>
                <th>author</th>
               <th>post</th>
                 <th>date</th>
                   <th>status</th>
                    <th>comments</th>
                    <th>teaser</th>
                    <th>type</th>
                 <th>icon</th>
                   <th>sort</th>
                    <th>permalink</th>
                    <th>showblog</th>
                      <th>startdate</th>
                    <th>enddate</th>
                   
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['cat']?></td>
                <td><?=$user['title']?></td>
                <td><?=$user['author']?></td>
                <td><?=$user['post']?></td>
                 <td><?=$user['date']?></td>
                <td><?=$user['status']?></td>
                <td><?=$user['comments']?></td>
               <td><?=$user['teaser']?></td>
                <td><?=$user['type']?></td>
                <td><?=$user['icon']?></td>
                <td><?=$user['sort']?></td>
                <td><?=$user['permalink']?></td>
                <td><?=$user['showblog']?></td>
                 <td><?=$user['startdate']?></td>
                <td><?=$user['enddate']?></td>
                
            </tr>
    <?php

?>
        </tbody>
    </table>
<?php



}
$fileverioncheck = "6.1.0";

