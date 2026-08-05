<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<div id=\"notification\"></div>\n";
$pageid = 373;
checkPagePermission($pageid);
echo "<style>\n    .tooltiptext{\n        margin-top: 80px;\n        margin-left: 680px;\n    }\n</style>\n";
if ($_ff_onSUBMIT_FILTER == "Search" || $action == "edit" || $p) {
    include "productsorder.head.php";
    echo "<div id='tabcontent'>";
}
if ($status != "all") {
    if ($status == "unshipped") {
        $usercanc = " and `orderstatus`='accepted'";
    } else {
        $usercanc = " and `orderstatus`='new' and status='Paid'";
    }
}

$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_invoices");
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
                <th>Order</th>
                <th>Date</th>
                 <th>Customer</th>
                  <th>Payment</th>
                   <th>Status</th>
                     <th>Amount</th>
                     <th>Amount</th>
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['userid']?></td>
                <td><?=$user['paymentmethod']?></td>
                <td><?=$user['orderstatus']?></td>
                <td><?=$user['Status']?></td>
                <td><?=$user['receivedamount']?></td>
                
                
               
                
                
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=productorder.edit&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>