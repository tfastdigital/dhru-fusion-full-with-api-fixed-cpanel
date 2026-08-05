<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 279;
checkPagePermission($pageid);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\" >\n    <style>\n        .enable{\n            background-color: #6dd076;\n            color:white;\n            padding: 3px;\n            font-size: 12px;\n        }\n        .disable{\n            background-color: #d0645a;\n            color:white;\n            padding: 3px;\n            font-size: 12px;\n        }\n    </style>\n";
if ($delete && $id) {
    dquery("DELETE from tbl_emailtemplates WHERE id='" . $id . "'");
    echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
}
if ($sched && $id) {
    dquery("UPDATE tbl_emailtemplates set scheduled=IF(scheduled=1,0,1) where id='" . $id . "'");
}
if ($IsFileOnly) {
    $req = dquery("SELECT distinct type FROM `tbl_emailtemplates` where \n    `type`!='imeiorder' and `type`!='serverorder' and `type`!='product'\n    and `type`!='imeiorderbulk'");
    while ($data = mysqli_fetch_assoc($req)) {
    }
    echo "</div></div>\n";
    $fileverioncheck = "6.1.0";
} else {
    $req = dquery("SELECT distinct type FROM `tbl_emailtemplates`");
}
if (!($OnlyEcommerce && ($data["type"] == "imeiorder" || $data["type"] == "fileorder" || $data["type"] == "serverorder" || $data["type"] == "imeiorderbulk"))) {
    echo "<div class=\"groupstabes first\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">";
    echo $data["type"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n<table id=\"main_tbl\" >";
    $req1 = dquery("SELECT `id`,`name`,`disabled`,`custom`,scheduled FROM `tbl_emailtemplates` WHERE `type`='" . $data["type"] . "'");
    while ($data1 = mysqli_fetch_assoc($req1)) {
        echo "<tr>";
        echo "<td style='width:80%'><a class='' \nhref=\"javascript:load_subpage('main2.php?page=emailtemplate.edit&id=" . $data1["id"] . "', 'Edit Email Template')\"\n> " . $data1["name"] . "</a></td>";
        if ($config["mail_sending_type"] == 1) {
            echo "        <td >\n        <a href=\"javascript: reloadcurrent('mailsetting&laoddefaultpage=emailtemplate.list.php&sched=true','";
            echo $data1["id"];
            echo "');\">\n       ";
            if ($data1["scheduled"]) {
                echo "        Scheduled\n        ";
            } else {
                echo "         Instant\n      ";
            }
            echo "</a></td>\n        ";
        }
        echo "        <td class=\"text-center\">";
        echo $data1["disabled"] == 1 ? "<span class='disable' >" . $LNG["disable"] . "</span>" : "<span class='badge badge-success'>" . $LNG["enable"] . "</span>";
        echo "</td>\n        ";
        if ($data1["custom"]) {
            echo "<td align='right' class='action'>\n<a class='default_dg_a2 editdata' href=\"javascript:reloadcurrent('emailtemplate.edit','" . $data1["id"] . "')\"> " . $LNG["edit"] . " </a><a class='default_dg_a2 deletedata' style='color:red !important;' onclick=\"return confirm('Are you sure want to remove email template?');\" href=\"javascript:redirectedit('mailsetting','" . $data1["id"] . "&laoddefaultpage=emailtemplate.list.php&delete=true')\"> " . $LNG["delete"] . " </a> </td>";
        } else {
            echo "<td align='right' class='action'><a class='default_dg_a2 editdata'\nhref=\"javascript:load_subpage('main2.php?page=emailtemplate.edit&id=" . $data1["id"] . "','Edit Email Template')\"> \n" . $LNG["edit"] . " </a><div class='blank'></div></td>";
        }
        echo "</tr>";
    }
    echo "</table></div></div>\n";
}

$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM  tbl_emailtemplates");
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
               
                <th>Edit</th>
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['name']?></td>
              
                <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=emailtemplate.edit&id=<?=$user['id']?>">Edit</a></td>
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>