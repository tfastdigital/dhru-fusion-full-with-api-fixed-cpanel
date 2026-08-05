<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 350;
checkPagePermission($pageid);
echo "<div id=\"tabcontent\">\n<!--\n<ul id=\"tabmenu\">     \n    <li><a ";
if (!$bywhom || $bywhom == "User") {
    echo " class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab','main2.php?page=unpaidinvoice&bywhom=User','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
echo $LNG["_by"];
echo " ";
echo $LNG["user"];
echo "</a></li>\n    <li><a ";
if ($bywhom == "Admin") {
    echo " class='tabmenu_active' ";
}
echo " onclick=\"getContect('#tab1','main2.php?page=unpaidinvoice&bywhom=Admin','','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
echo $LNG["_by"];
echo " ";
echo $LNG["admin"];
echo "</a></li>      \n   <div style=\"clear: both;\"></div>\n</ul>\n-->\n";
$q = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($q)) {
    $curt = mysqli_fetch_assoc(dquery("select sum(total) as tot from \n    tbl_invoices  where status='Unpaid' and adminid!=''\n    and userid in (select id from tblUsers where default_currency='" . $r["id"] . "')"));
    if ($curt["tot"]) {
        $Collection[$r["id"]] = [$curt["tot"], $r["code"]];
    }
}
echo " \n<script>\nfunction filterby(currencyid)\n{\n    location.href='main2.php?page=unpaidinvoice&_ff_onSUBMIT_FILTER=Search&_ff_tblUsers_default_currency='+currencyid;\n}\n</script>\n\n<div>\n";
$i = 1;
foreach ($Collection as $id => $detail) {
    if (count($Collection) == $i) {
        echo "<span onclick='filterby(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#ad0808'>" . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small> </span>   ";
    } else {
        echo "<span onclick='filterby(" . $id . ")' style='font-size:30px; cursor:pointer;margin-right:30px;color:#ad0808'> " . $detail[0] . " <small style='color:gray'> " . $detail[1] . " </small>   </span>  ";
    }
    $i++;
}
echo "</div>\n\n\n";
include_once DATAGRID_DIR2 . "comm.php";
if ($deleteinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("DELETE FROM tbl_invoices WHERE id='" . $val . "'");
        dquery("DELETE FROM tbl_invoiceitems WHERE invocieid='" . $val . "'");
    }
    $success = "Invoice Removed successfully";
}
if ($cancelinvoice) {
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    foreach ($ids as $val) {
        dquery("update tbl_invoices set status='Cancel' where id=" . $val);
    }
}
if ($error) {
    echo "<div id=notification class=errorbox>" . $error . "</div>";
}
if ($success) {
    echo "<div id=notification class=successbox>" . $success . "</div>";
}
echo "\n";
if ($bywhom != "Admin") {
}
$summary = NULL;
if (!$status) {
    $status = "Unpaid";
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
                <th>Reference ID</th>
                <th>Username</th>
                <th>Create Date</th>
               <th>Due Date</th>
                 <th>Total</th>
                   <th>Düzenle</th>
                  
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['userid']?></td>
                <td><?=$user['userid']?></td>
                <td><?=$user['date']?></td>
                <td><?=$user['duodate']?></td>
                 <td><?=$user['total']?></td>
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