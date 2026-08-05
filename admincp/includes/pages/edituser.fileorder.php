<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n\n";
if ($_ff_onSUBMIT_FILTER == "Search" || $p) {
    include "edituser.head.php";
    echo "<div id=\"tabcontent\"> ";
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
$clientDetails = getClientsDetails($id);
if ($clientDetails["userstatus"] != "0") {
    echo "<div id=\"notification1\" class=\"info\">";
    if ($clientDetails["userstatus"] == "1") {
        $status = $LNG["thisaccounthasbeen"] . " " . $LNG["blocked"];
    } else {
        if ($clientDetails["userstatus"] == "2") {
            $status = $LNG["thisaccounthasbeen"] . " " . $LNG["inactive"];
        }
    }
    echo "<span><strong>";
    echo $status;
    echo "</strong></span></div>";
}
$pageid = 192;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
$sql = "SELECT \norder_id,\ndate, \nfile,\n(select value from tbl_apiservers where gateway=(select API\nfrom tbl_services_file where id=service_id) AND setting = 'name') as apiname,\n\nCONCAT('<span> <a class=\\'default_dg_a\\' href=\"javascript:load_fromsubpage(\\'editfileservice&id=',service_id,'\\',\\' ',(select service_name from tbl_services_file\nwhere id=service_id),'\\')\">','[#',service_id,']</a>  ',(select service_name from tbl_services_file\nwhere id=service_id),'</span>') as service_name, \nIF(user_can_c = 0,'" . $LNG["new"] . "',IF(user_can_c = 1,CONCAT('<span class=textblue>','" . $LNG["inprocess"] . "','</span>'),IF(user_can_c = 3,CONCAT('<span class=textred>','" . $LNG["rejectedorder"] . "','</span>'),CONCAT('<span class=textgreen>','" . $LNG["availableorder"] . "','</span>')))) as status,\nif(verified = '1', '" . $img_black . "',IF(verified = '2','" . $img_gray . "','" . $img_trans . "')) AS flags,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser.editfileorder&id=',order_id,'\\',\\'File#',order_id,'\\')\">" . $LNG["edit"] . "</a>') as action_links\nFROM `tbl_order_file` \nWHERE user_id =" . $id . " and user_can_c <> '5'";
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
    $stmt = $pdo->query("SELECT * FROM  tbl_order_file");
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
                <th>Date</th>
                <th>IMEI</th>
                <th>Services</th>
                <th>API</th>
                <th>Order Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['order_id']?></td>
                 <td><?=$user['date']?></td>
                  <td><?=$user['imei']?></td>
                   <td><?=$user['service_id']?></td>
                <td><?=$user['ORDERAPI']?></td>
                 <td><?=$user['credit']?></td>
                 
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=edituser.editimeiorder&id=<?=$user['order_id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>