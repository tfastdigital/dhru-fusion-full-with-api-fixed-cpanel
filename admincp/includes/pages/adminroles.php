<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($mode == "Delete Admin Role" || $btnaddrolegroup) {
    include "admin.head.php";
    echo "<div id=tabcontent>";
}
echo " <script>\n    subheader2_txt('');\n </script>\n";
$pageid = 168;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
echo "<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($btnaddrolegroup) {
    checkDemoMode(false);
    if ($name) {
        $sql = dquery("select group_name from tbl_admin_access_group where group_name='" . $name . "'");
        if (!mysqli_num_rows($sql)) {
            $data["group_name"] = $name;
            if ($db->insert("tbl_admin_access_group", $data)) {
                $success = "<li>" . $LNG["datasavesuccessfully"] . "</li>";
            } else {
                $error = "<li>" . $LNG["datanotsave"] . "</li>";
            }
        } else {
            $error = "<li>" . $LNG["adminrole"] . " " . $LNG["already"] . " " . $LNG["exists"] . "</li>";
        }
    } else {
        $error = "<li>" . $LNG["adminrole"] . " " . $LNG["required"] . "</li>";
    }
}
if ($deleteadminrole) {
    checkDemoMode(false);
    $ids = str_replace("-", ",", $rid);
    $ids = explode(",", $ids);
    $id = (string) $LNG["cannotdelete"];
    foreach ($ids as $val) {
        if ($val == "1") {
            $error = "<li>" . $LNG["cannotdeleteadminisratorgroup"] . "</li>";
        }
        $get = mysqli_num_rows(dquery("select * from tbl_admin where group_id=" . $val));
        if ($get != "0") {
            $id .= $val . ",  ";
        } else {
            if (dquery("delete from tbl_admin_access_group where id=" . $val)) {
                $success = (string) $LNG["successfullydeleted"];
            }
        }
    }
    $error .= "<li>" . $id . $LNG["idassigntoadmin"] . "</li>";
}
if ($success) {
    echo "<div id=notification1 class=successbox>" . $success . "</div>";
} else {
    if ($error) {
        echo "<div id=notification1 class=errorbox>" . $error . "</div>";
    }
}
echo "\n<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Add New Admin Role</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form action=\"\" method=\"post\">\n<input type=\"hidden\" name=\"page\" value=\"adminroles\"/>\n<input type=\"hidden\" name=\"loaddefault\" value=\"adminroles.php\"/>\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"50%\">\n<tbody>\n<tr><td class=\"fieldlabel\"  align=\"middle\">";
echo $LNG["adminrole"];
echo "</td><td class=\"fieldarea\">\n<input name=\"name\" value=\"";
echo $access_group["group_name"];
echo "\" type=\"text\"  class=\"txt medium\" />\n<input type=\"hidden\" name=\"defaultload\" value=\"adminroles.php\"/>\n</td>\n<tr><td></td><td class=\"fieldarea\">\n<input value=\"";
echo $LNG["save"];
echo "\" name=\"btnaddrolegroup\" class=\"btn save\" type=\"submit\" /></td></tr>\n</tbody></table>\n</form>\n</div></div>\n</div></div>\n";
$sql = "SELECT tbl_admin_access_group.id,\nIF(id=1,tbl_admin_access_group.group_name,\nCONCAT('<a class=\\'default_dg_a\\' onclick=\"getContect(\\'#tab3\\',\\'main2.php?page=editadminaccessgroup\\',',tbl_admin_access_group.id,',\\'\\',\\'#tabcontent\\',\\'true\\',\\'#main_loader\\');\">',tbl_admin_access_group.group_name,'</a>')) as group_name,\nIF(id=1,'',\nCONCAT( '<a class=\\'default_dg_a2 editdata\\' onclick=\"getContect(\\'#tab3\\',\\'main2.php?page=editadminaccessgroup\\',',tbl_admin_access_group.id,',\\'\\',\\'#tabcontent\\',\\'true\\',\\'#main_loader\\');\">" . $LNG["edit"] . "</a>' ))  AS action_links\nFROM tbl_admin_access_group\n";
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
    $stmt = $pdo->query("SELECT * FROM tbl_admin_access_group");
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
                <th>Name</th>
                
               <th>Duzenle</th>
                
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['id']?></td>
                <td><?=$user['group_name']?></td>
             
                
                 <td><a style="    background: #28ac7c;
    color: white;
    padding: 5px 10px;
    text-align: center;
    border-radius: 3px;" href="https://diamondgsm.com/admincp/main2.php?page=editadmin&admn=<?=$user['id']?>">Düzenle</a></td>
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>