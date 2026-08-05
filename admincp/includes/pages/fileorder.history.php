<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 189;
checkPagePermission($pageid);
echo "<style>\n.dg_right{text-indent:2px !important;}\n</style>\n    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n";
include ROOTDIR . "/includes/clients.fun.inc.php";
include DATAGRID_DIR2 . "comm.php";
if ($action == "refund" && $id) {
    $sql = "SELECT \n    order_id,date, credit,  discount,\n    (select value from tbl_apiservers where gateway=(select API\n    from tbl_services_file where id=service_id) AND setting = 'name') as apiname,\n    (select API from tbl_services_file where id=service_id) as API,\n    credit-discount as total,   \n    (SELECT `service_name` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id) AS service,\n    file,  (SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_file.user_id) as username,\n    CONCAT(IF(tbl_order_file.user_can_c=0,'New', IF(tbl_order_file.user_can_c=1,'Accepted',IF(tbl_order_file.user_can_c=4,'Replied','Rejected'))) ) as status,\n    CONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser.editfileorder&id=',order_id,'\\',\\'File#',order_id,'\\')\">" . $LNG["edit"] . "</a>') as action_links\n    FROM `tbl_order_file` LEFT OUTER JOIN tblUsers ON\n    `tbl_order_file`.user_id = tblUsers.id WHERE `user_can_c`='3' and service_id='" . $id . "'";
    echo "    <div id=\"tabcontent\">\n    ";
} else {
    $sql = "SELECT \n    order_id,date,credit,discount,\n    (select value from tbl_apiservers where gateway=(select API\n    from tbl_services_file where id=service_id) AND setting = 'name') as apiname,\n    (select API from tbl_services_file where id=service_id) as API,\n    credit-discount as total,   \n    \n    concat('<div class=\"boxes\" style=\"background-color: ',(SELECT `colortag` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id),'\"></div>',(SELECT `service_name` FROM `tbl_services_file` WHERE `id`=tbl_order_file.service_id)) as service,\n\n    \n    file,(SELECT `username` FROM `tblUsers` WHERE `id`=tbl_order_file.user_id) as username,\n    CONCAT(IF(tbl_order_file.user_can_c=0,'New', IF(tbl_order_file.user_can_c=1,'Accepted',IF(tbl_order_file.user_can_c=4,'Replied','Rejected'))) ) as status,\n    CONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript:load_fromsubpage(\\'edituser.editfileorder&id=',order_id,'\\',\\'File#',order_id,'\\')\">" . $LNG["edit"] . "</a>') as action_links\n    FROM `tbl_order_file` WHERE `user_can_c`!='5'";
}
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
    $stmt = $pdo->query("SELECT * FROM tbl_order_imei");
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
                 <th>Completed In</th>
                  <th>Service	API</th>
                   <th>Username</th>
                    <th>IMEI</th>
                     <th>Status</th>
                <th>Düzenle</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['status']?></td>
                <td><?=$user['service_id']?></td>
                <td><?=$user['user_id']?></td>
                <td><?=$user['imei']?></td>
                <td><?=$user['status']?></td>
                
               
                
                
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=edituser.editinvoice&id=<?=$user['id']?>">Düzenle</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>