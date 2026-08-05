<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 256;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/fileservices.fun.php";
$row = mysqli_fetch_assoc(dquery("select service_name from tbl_services_file where id='" . $id . "'"));
echo "    \n <script>  \n    subheader2_txt('[";
echo $LNG["view"];
echo " ";
echo $LNG["order"];
echo " ";
echo $LNG["for"];
echo " ";
echo $LNG["verification"];
echo ": ";
echo $row["service_name"];
echo "]');\n </script>\n";
if ($extract) {
    echo "\n<ul id=\"tabmenu\"> \n    <li><a onclick=\"getContect('#tab','main2.php?page=filequickaccept','','','#tabcontent',true,'#main_loader');\" id=\"tab33\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab','main2.php?page=fileorder.new','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>       \n    <li><a onclick=\"getContect('#tab2','main2.php?page=fileorder.repllied','','','#tabcontent',true,'#main_loader');\" id=\"tab2\" >";
    echo $LNG["replyaccepted"];
    echo "</a></li>\n    <li><a  ";
    if ($loaddefaultpage == "fileorder.verification.php" || $extract) {
        echo "class='tabmenu_active'";
    }
    echo "   onclick=\"getContect('#tab3','main2.php?page=fileorder.verification','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab4','main2.php?page=fileorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["orderhistory"];
    echo "</a></li>\n    <div style=\"clear: both;\"></div>\n</ul> \n\n<div id=\"tabcontent\">\n";
}
if (isset($_POST["select"])) {
    checkDemoMode(false);
    foreach ($_POST["select"] as $oid) {
        if (isset($_POST["reject"][$oid])) {
            $data["reason"] = $_POST["reason"][$oid];
            $data["verified"] = 2;
            $data["verified_by_admin"] = $_SESSION["adminid"];
            $db->update("tbl_order_file", $data, "order_id=" . $oid);
            $data = NULL;
            rejectFile(md5($oid), "Rejected", $_SESSION["adminid"]);
        } else {
            if ($_FILES["reply"][$oid]["error"] <= 0 || $_POST["replytext"][$oid] != "") {
                if ($_POST["replytext"][$oid] != "") {
                    $REPLY = $_POST["replytext"][$oid];
                } else {
                    $REPLY = $_FILES["reply"]["name"][$oid];
                    $fext = substr($REPLY, strrpos($REPLY, "."));
                    $file = str_replace($fext, "", $REPLY);
                    $Enc = md5(md5($oid) . $file) . $fext;
                    move_uploaded_file($_FILES["reply"]["tmp_name"][$oid], "../" . $donloaddirpath . "/" . $Enc);
                    $data["reply_enc"] = $Enc;
                }
                $data["reply"] = $REPLY;
                $data["verified"] = 2;
                $data["verified_by_admin"] = $_SESSION["adminid"];
                $db->update("tbl_order_file", $data, "order_id=" . $oid);
                $data = NULL;
            }
        }
        $success = $LNG["verifiedsucc"];
    }
    if ($error) {
        echo "<div id=notification class=errorbox>" . $error . "</div>";
    }
    if ($success) {
        echo "<div id=notification class=successbox>" . $success . "</div>";
    }
}
$fileOrders = getOrdersFile("", md5($id), "", "", "1");
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($extract) {
    $buf = "";
    $sql = dquery("SELECT `order_id`,`file` FROM `tbl_order_file` where\n     `service_id`='" . $id . "' and `verified`='1' and user_can_c=4");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= $row["order_id"] . "  : " . $row["file"] . " &#10;-------------------------------&#10;";
    }
    echo "<textarea class=\"textarea large\" rows=\"5\">\n";
    echo $buf;
    echo "</textarea>\n";
}
echo "<div align=\"right\">\n    <input type=\"button\" name=\"extract\" onclick=\"load_subpage('main2.php?page=viewfileorder.verif&id='+";
echo $id;
echo "+'&extract=true'','";
echo $LNG["extractall"];
echo "');\"  value=\"";
echo $LNG["extractall"];
echo "\" />\n</div><br />\n<form id=\"replied\" name=\"replied\" method=\"post\" enctype=\"multipart/form-data\" >\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"viewfileorder.verif.php\" />\n<input type=\"hidden\" name=\"id\" value=\"";
echo $id;
echo "\" />\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th><!--\n<input type=\"checkbox\" name=\"checkall\" onclick=\"CheckAll();\" />\n--></th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n        <th>";
echo $LNG["date"];
echo "</th>\n        <th>";
echo $LNG["credit"];
echo " </th>\n        <th>";
echo $LNG["file"];
echo " </th>\n        <th>";
echo $LNG["reply"];
echo " </th>\n         <th>";
echo $LNG["username"];
echo " </th>\n        <th>";
echo $LNG["reply"];
echo " </th>  \n        <th>\n<input type=\"checkbox\" name=\"reject\" onclick=\"RCheckAll();\"/>\n Reject </th>\n  </tr>\n</thead> \n<tbody> \n            \n            \n";
$cnt = 1;
if ($fileOrders) {
    foreach ($fileOrders as $id => $Orders) {
        echo "    <tr>\n        <td><input type=\"checkbox\" name=\"select[]\" id=\"select\" value=\"";
        echo $id;
        echo "\" /></td>\n        <td>";
        echo $Orders["service"];
        echo "</td>\n        <td>";
        echo $Orders["date"];
        echo "</td>\n        <td>";
        echo $Orders["credit"] - $Orders["discount"];
        echo " ";
        echo $Orders["code"];
        echo "</td> \n        <td>";
        echo $Orders["file"];
        echo "</td>  \n        <td>";
        echo $Orders["reply"];
        echo "</td> \n        <td>";
        echo $Orders["username"];
        echo "</td> \n        <td width=\"200px\"><div id=\"fileshow[";
        echo $cnt;
        echo "]\">\n         ";
        if ($Orders["service_type"]) {
            echo "        <input type=\"file\" name=\"reply[";
            echo $id;
            echo "]\" />\n        ";
        } else {
            echo "        <input type=\"text\"  name=\"replytext[";
            echo $id;
            echo "]\" />\n        ";
        }
        echo "</div>\n        <div id=\"reasonshow[";
        echo $cnt;
        echo "]\" style=\"display: none;\">\n        <input type=\"text\"  name=\"reason[";
        echo $id;
        echo "]\" /></div>\n        </td> \n        <td><input type=\"checkbox\" name=\"reject[";
        echo $id;
        echo "]\"  onclick=\"showReas('";
        echo $cnt;
        echo "')\"  id=\"reject\" value=\"";
        echo $id;
        echo "\" /><label onclick=\"showReas('";
        echo $cnt;
        echo "')\"></label></td>\n    </tr>\n    ";
        $cnt = $cnt + 1;
    }
}
echo "\n\n</tbody></table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"Reply Selected\" /></p>\n</form></div></div> \n<script>\nfunction showReas(ids)\n{\n    if(document.replied.reject[ids].checked==true)\n    {\n         document.getElementById('reasonshow['+ids+']').style.display=\"\";\n         document.getElementById('fileshow['+ids+']').style.display=\"none\";       \n    }else{\n         document.getElementById('reasonshow['+ids+']').style.display=\"none\";\n         document.getElementById('fileshow['+ids+']').style.display=\"\";           \n    }\n}\nfunction CheckAll()\n{    \n\t\tvar i=document.replied.select.length;        \n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\t\t     \n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{\n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n        var arr= document.getElementById('reasonshow');\n\t\tfor (k=1 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t     document.replied.reject[k].checked=false;\n                 document.getElementById('reasonshow['+k+']').style.display=\"none\";\n                 document.getElementById('fileshow['+k+']').style.display=\"\";\n      \t\t}\n\t\t\telse\n\t\t\t{ \n\t\t\t     document.replied.reject[k].checked=true;\n                 document.getElementById('reasonshow['+k+']').style.display=\"\";\n                 document.getElementById('fileshow['+k+']').style.display=\"none\";\n\t\t\t}\n\t\t}\n}\n</script>\n";
if ($extract) {
    echo "</div>";
}
$fileverioncheck = "6.1.0";

?>