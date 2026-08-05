<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\nfunction openNewWin(id){\n    window.open('includes/pages/viewmail.php?id='+id,'name','location=no,toolbar=no,menubar=no,scrollbars=yes,status=no,width=500,height=500');\n}\n</script>\n";
if ($_ff_onSUBMIT_FILTER == "Search" || $mode == "delete" || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
$pageid = 169;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
$sql = "SELECT tbl_email_history.id,date,subject,\nCONCAT('<a class=\\'default_dg_a2\\' \nonclick=\"javascript: openNewWin(',tbl_email_history.id,')\">View</a>') AS action_links\n FROM tbl_email_history where userid=" . $id;
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
    $stmt = $pdo->query("SELECT * FROM  tbl_email_history");
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
                <th>Subject</th>
                <th>Message</th>
                
                <th>Created Dates</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                 <td><?=$user['subject']?></td>
                  <td><?=$user['message']?></td>
                   <td><?=$user['date']?></td>
               
                
                 
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
   border-radius: 3px;" target="_blank" href="https://diamondgsm.com/admincp/includes/pages/viewmail.php?&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>