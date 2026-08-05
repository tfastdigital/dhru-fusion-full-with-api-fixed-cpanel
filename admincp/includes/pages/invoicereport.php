<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"javascript:void(0)\">Invoice Report</a></li>\n</ul>\n";
$pageid = 350;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
if ($id) {
    $currency = " and default_currency=" . $id;
}
$WHERE = "";
if ($bywhom == "User") {
    $WHERE = " and adminid=''";
}
if ($unpaidonly) {
    $WHERE .= " and status='Unpaid'";
}
if ($paidonly) {
    $WHERE .= " and (status='Paid' or (status='Unpaid' and onhold=1)  ) and default_currency='" . $currency . "'";
    $page_size = 50;
    $mode = "view";
    $p = 1;
}
if ($cancelinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("update tbl_invoices set status='Cancel' where id=" . $val);
    }
}
if ($deleteinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("DELETE FROM tbl_invoices WHERE id='" . $val . "'");
        dquery("DELETE FROM tbl_invoiceitems WHERE invocieid='" . $val . "'");
    }
    $success = "Invoice Removed successfully";
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
echo "\n";
$sql = "SELECT\ntbl_invoices.id, username,\n  IF(status='Unpaid',concat('P/',mask),concat('I/',tbl_invoices.id) ) as invoiceno,\nCONCAT(tbl_invoices.total,' ',(select code from tbl_currencies where tbl_currencies.id= default_currency)) AS total,\ntbl_invoices.credit,  \ntbl_invoices.date,\nCONCAT(IF(tbl_invoices.adminid='','User','Admin')) as bywhom,\ntbl_invoices.duedate,\nif(tbl_invoices.duedate < CURDATE() and status='Unpaid','" . $img_red . "','" . $img_trans . "') as flag,\nCONCAT('<a \n onclick=\"load_subpage(\\'main2.php?page=edituser.editinvoice&id=',tbl_invoices.id,'\\',\\'" . $LNG["edit"] . " " . $LNG["invoice"] . "\\');\">" . $LNG["edit"] . "</a>')\nas action_links\nFROM tbl_invoices\n left outer join tblUsers \non tbl_invoices.userid=tblUsers.id\nwhere total>0 " . $WHERE . " ";
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
                <th>ID</th>
                <th>Username</th>
                <th>Create Date</th>
                <th>Due Date</th>
                <th>Total</th>
                 <th>Actions</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['userid']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['duedate']?></td>
                <td><?=$user['total']?></td>
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=edituser&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>