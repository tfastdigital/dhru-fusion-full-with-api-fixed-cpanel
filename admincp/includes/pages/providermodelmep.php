<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 502;
checkPagePermission($pageid);
include_once DATAGRID_DIR2 . "comm.php";
if (isset($_GET["rid"])) {
    echo "<div id='tabcontent'>";
    $DEL = explode("-", $_GET["rid"]);
    if (count($DEL)) {
        foreach ($DEL as $d) {
            dquery("DELETE FROM tbl_provider_model_mep WHERE id='" . $d . "'");
        }
        echo "<div id='notification' class='successbox'>" . $LNG["datadeletesuccessfully"] . "</div>";
    }
}
echo "<script>\n \$(document).ready(function() {\n\n    \$('#country').change(function() {\n        var str;\n        str = \$(this).val();\n         if(str!=''){\n             \$.get(\"includes/pages/getFields.php\", { id: str,type: 'country',api: '";
echo $id;
echo "'},\n             function(data){\n                \$(\"#provider\").html(data);\n            });\n       }\n    });\n    \n \n    \$('#brand').change(function() {\n        var str;\n        str = \$(this).val();\n         if(str!=''){\n             \$.get(\"includes/pages/getFields.php\", { id: str,type: 'brand',api: '";
echo $id;
echo "'},\n             function(data){\n                \$(\"#model\").html(data);\n            });\n       }\n    });\n       \n });\n</script>\n<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Provider Model MEP</a></li>\n</ul>\n<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">";
echo $LNG["listing"];
echo "  </td>\n    <td class=\"fieldarea\" colspan=\"3\">\n<select name=\"api\" class=\"chosen\" onchange=\"javascript:reloadcurrent('providermodelmep', this.value);\">\n<option value=\"\">";
echo $LNG["none"];
echo "</option>\n";
$api = dquery("select distinct gateway,value from tbl_apiservers  where  tbl_apiservers.setting='name'");
while ($rowapi = mysqli_fetch_assoc($api)) {
    echo "<option value='";
    echo $rowapi["gateway"];
    echo "' ";
    if ($rowapi["gateway"] == $id) {
        echo "selected";
    }
    echo " >";
    echo $rowapi["value"];
    echo "</option>\n";
}
echo "    \n</select> &nbsp; <a href=\"#\" data-target=\"apisetting\" data-target-header=\"";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "\" onclick=\"AddnewInpopup(this);\">";
echo $LNG["manage"];
echo " ";
echo $LNG["api"];
echo "</a>   \n</td>\n</tr>\n";
if ($id) {
    echo "<tr>\n    <td class=\"fieldlabel\">";
    echo $LNG["country"];
    echo "</td>\n     <td class=\"fieldarea\" >\n     <select name=\"country\" id=\"country\">\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n     ";
    $d = dquery("SELECT * from tbl_provider_country WHERE api='" . $id . "'");
    if (mysqli_num_rows($d)) {
        while ($row = mysqli_fetch_assoc($d)) {
            echo "            <option value=\"";
            echo $row["ID"];
            echo "\">";
            echo $row["Name"];
            echo "</option>\n         ";
        }
    }
    echo "     </select>\n     </td>\n     <td class=\"fieldlabel\">";
    echo $LNG["brand"];
    echo "</td>\n     <td class=\"fieldarea\" >\n     <select name=\"brand\" id=\"brand\">\n        <option value=\"\">";
    echo $LNG["select"];
    echo "</option>\n     ";
    $d = dquery("SELECT * from tbl_model_brand WHERE api='" . $id . "'");
    while ($row = mysqli_fetch_assoc($d)) {
        echo "        <option value=\"";
        echo $row["ID"];
        echo "\">";
        echo $row["Name"];
        echo "</option>\n     ";
    }
    echo "     </select>\n     </td>   \n</tr>\n<tr >\n    <td class=\"fieldlabel\">";
    echo $LNG["provider"];
    echo "</td>\n     <td class=\"fieldarea\" id=\"provider\" >";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["country"];
    echo "     </td>\n    <td class=\"fieldlabel\">";
    echo $LNG["model"];
    echo "</td>\n     <td class=\"fieldarea\" id=\"model\" >";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["brand"];
    echo "     </td>  \n</tr>\n";
}
echo "<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mep"];
echo "</td>\n    <td colspan=\"3\" class=\"fieldarea\">\n    <input type=\"text\" name=\"mep\" />\n</td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\">";
echo $LNG["mep"];
echo " ";
echo $LNG["listing"];
echo "</td>\n    <td colspan=\"3\" class=\"fieldarea\">\n<input type=\"checkbox\" value=\"1\" name=\"mep1\" id=\"mep1\" /> <label for=\"mep1\">";
echo $LNG["mep"];
echo " 2</label>\n&nbsp;\n<input type=\"checkbox\" value=\"1\" name=\"mep4\" id=\"mep4\" /> <label for=\"mep4\">";
echo $LNG["mep"];
echo " 4</label>\n</td>\n</tr>\n\n<tr>\n    <td  class=\"fieldlabel\"></td>\n    <td colspan=\"3\" class=\"fieldarea\">\n<input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn add\" type=\"button\"  onclick=\"SubmitForm ('#btnaddgroup','providermodelmep','#frm','#notification','true','#main_loader');\"/> \n</td>\n</tr>\n\n</tbody>\n</table>\n\n\n</form>\n\n\n</div></div>\n\n<br /><br /><br />\n \n";
$sql = "SELECT  \nid,mep,pid,mid,\nCONCAT(\n(select `Name` from tbl_provider_country where ID=(SELECT C_ID from tbl_provider where ID=pid) )\n,'-',\n(select `Name` from tbl_provider where ID=pid)) as provider\n,\nCONCAT(\n(select `Name` from tbl_model_brand where ID=(SELECT B_ID from tbl_mobile where ID=mid) )\n,'-',\n(select `Name` from tbl_mobile where ID=mid)) as model,\nCONCAT('<a class=\\'default_dg_a2 editdata\\' href=\"javascript: void(0)\" \n   onclick=\"load_subpage(\\'includes/pages/editprovidermodelmep.php?id=',tbl_provider_model_mep.id,'\\', \\'" . $LNG["edit"] . "\\');   \n    return false;\" >" . $LNG["edit"] . "</a>') as action_links\nFROM tbl_provider_model_mep where 1=1 ";


$DB_USER = "dkmunssk_dhru10";
$DB_PASS = "dkmunssk_dhru10";      
$DB_HOST = "localhost";      
$DB_NAME = "dkmunssk_dhru10";  

  $pdo = new PDO("mysql:host=localhost;dbname=dkmunssk_dhru10", "dkmunssk_dhru10", "dkmunssk_dhru10");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SELECT * FROM tbl_provider_country");
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
                <th>date</th>
                <th>DESC</th>
               
            </tr>
        </thead>
        <tbody>
          <?php
             foreach ($users as $user) {
    ?>
         <tr>
                <td><?=$user['date']?></td>
                <td><?=$user['description']?></td>
              
               
            </tr>
    <?php
}

?>
        </tbody>
    </table>
<?php



?>
?>