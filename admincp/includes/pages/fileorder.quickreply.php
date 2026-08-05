<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 88;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/fileservices.fun.php";
if (isset($replyorders)) {
    checkDemoMode(false);
    $Flag = true;
    foreach ($_POST["reason"] as $oid => $val) {
        if (trim($val)) {
            $Flag = false;
            $REPLY = $_POST["reason"][$oid];
            $data["reason"] = $_POST["reason"][$oid];
            $db->update("tbl_order_file", $data, "order_id=" . $oid);
            $data = NULL;
            rejectFile(md5($oid), $REPLY, $_SESSION["adminid"]);
        }
    }
    foreach ($_POST["reason"] as $oid => $val) {
        if ($_FILES["reply"][$oid]["error"] <= 0 || $_POST["replytext"][$oid] != "") {
            if ($_POST["replytext"][$oid] != "") {
                $REPLY = $_POST["replytext"][$oid];
            } else {
                $REPLY = $_FILES["reply"]["name"][$oid];
                $fext = substr($REPLY, strrpos($REPLY, "."));
                $file = str_replace($fext, "", $REPLY);
                $mdoid = md5($oid);
                $Enc = md5($mdoid . $file) . $fext;
                move_uploaded_file($_FILES["reply"]["tmp_name"][$oid], "../" . $donloaddirpath . "/" . $Enc);
            }
            $Flag = false;
            replySuccessFile(md5($oid), $REPLY, $_SESSION["adminid"]);
        }
    }
    if ($Flag) {
        echo "<div id=notification1 class=errorbox>" . $LNG["no"] . " " . $LNG["any"] . " " . $LNG["service"] . " " . $LNG["selected"] . "</div>";
    } else {
        echo "<div id=notification1 class=successbox>" . $LNG["orderrepliedsucc"] . "</div>";
    }
}
$pagelimit = 1000;
if ($config["orderdisplay"] == 2) {
    $default_order_type = "ASC";
} else {
    $default_order_type = "DESC";
}
if ($service) {
    $mdid = md5($service);
}
$imeiOrders = getOrdersFile("accepted", $mdid, "", "", "", $default_order_type);
echo "    <style>\n        .boxes{\n            width: 10px;\n            height: 10px;\n            float:left;\n            margin-top: 4px;\n            margin-right: 4px;\n        }\n    </style>\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n <h2 style=\"float: left;\">\n    <span class=\"groupstabesheadertext\">Quick Reply</span>\n  </h2>\n\n\n<form id=\"replied\" name=\"replied\" method=\"post\" enctype=\"multipart/form-data\" >\n\n\n<div style=\"float: right;margin-bottom: 10px;\">\n\n<select name=\"service\" id=\"sservice\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
$sql = dquery("SELECT service_id,(SELECT service_name FROM tbl_services_file WHERE id=service_id) \nAS service from tbl_order_file where user_can_c='1' group by service_id");
while ($rows = mysqli_fetch_assoc($sql)) {
    echo "<option ";
    if ($service == $rows["service_id"]) {
        echo "selected";
    }
    echo " value=\"";
    echo $rows["service_id"];
    echo "\" >";
    echo $rows["service"];
    echo "</option>\n";
}
echo "</select>\n\n<input type=\"submit\" class=\"btn btn-info\" name=\"finder\" value=\"";
echo $LNG["search"];
echo "\" />\n\n</div>\n\n<div class=\"clear\"></div>\n<br />\n\n<input type=\"hidden\" name=\"laoddefaultpage\" value=\"fileorder.quickreply.php\" />\n\n\n";
echo generate_token("form");
echo "<table id=\"main_tbl\"  >\n<thead>\n  <tr>\n        <th>";
echo $LNG["order"];
echo " ";
echo $LNG["id"];
echo "</th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n        <th>";
echo $LNG["date"];
echo "</th>\n        <th>";
echo $LNG["total"] . " " . $LNG["credit"];
echo "</th>\n        <th>";
echo $LNG["username"];
echo " </th>\n        <th>";
echo $LNG["file"];
echo " </th>\n        <th>";
echo $LNG["reply"];
echo " </th>\n        <th>";
echo $LNG["reject"];
echo " ";
echo $LNG["reason"];
echo "</th>\n        <th></th>\n  </tr>\n</thead>\n<tbody>\n\n\n";
if ($imeiOrders) {
    $cnt = 1;
    foreach ($imeiOrders as $id => $Orders) {
        echo "    <tr id=\"hide_";
        echo $id;
        echo "\">\n        <td>\n            <a class=\"default_dg_a2 \" href=\"javascript:load_fromsubpage('edituser.editfileorder&id=";
        echo $id;
        echo "','File#";
        echo $id;
        echo "')\">";
        echo $id;
        echo "</a>\n        </td>\n        <td><div class=\"boxes\" style=\"background-color: ";
        echo $Orders["colortag"];
        echo "\"></div>";
        echo $Orders["service"];
        echo "</td>\n        <td>";
        echo $Orders["date"];
        echo "</td>\n        <td>";
        echo round($Orders["credit"] - $Orders["discount"], $precision);
        echo " ";
        echo $Orders["code"];
        echo "</td>\n        <td>";
        echo $Orders["username"];
        echo "</td>\n        <td>";
        echo $Orders["file"];
        echo "</td>\n        <td><div id=\"fileshow[";
        echo $cnt;
        echo "]\">\n        ";
        if ($Orders["service_type"]) {
            echo "        <input type=\"file\" style=\"width:100px !important;\" name=\"reply[";
            echo $id;
            echo "]\" />\n        ";
        } else {
            echo "        <input type=\"text\" style=\"width:100px !important;\" name=\"replytext[";
            echo $id;
            echo "]\" />\n        ";
        }
        echo "        </div>\n        </td>\n        <td><input type=\"text\" style=\"width:100px !important;\" name=\"reason[";
        echo $id;
        echo "]\" /></td>\n        <td></td>\n    </tr>\n    ";
        $cnt = $cnt + 1;
    }
}
echo "\n</tbody></table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"replyorders\"\n id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["selected"];
echo "\" /></p>\n</form></div></div>\n<script>\nfunction showReas(ids)\n{\n    if(document.replied.reject[ids].checked==true)\n    {\n         document.getElementById('reasonshow['+ids+']').style.display=\"\";\n         document.getElementById('fileshow['+ids+']').style.display=\"none\";\n    }else{\n         document.getElementById('reasonshow['+ids+']').style.display=\"none\";\n         document.getElementById('fileshow['+ids+']').style.display=\"\";\n    }\n}\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{\n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n        var arr= document.getElementById('reasonshow');\n\t\tfor (k=1 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t     document.replied.reject[k].checked=false;\n\n                 document.getElementById('reasonshow['+k+']').style.display=\"none\";\n                 document.getElementById('fileshow['+k+']').style.display=\"\";\n      \t\t}\n\t\t\telse\n\t\t\t{\n\n\t\t\t     document.replied.reject[k].checked=true;\n                 document.getElementById('reasonshow['+k+']').style.display=\"\";\n                 document.getElementById('fileshow['+k+']').style.display=\"none\";\n\t\t\t}\n\t\t}\n}\n</script>";
$fileverioncheck = "6.1.0";

?>