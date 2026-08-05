<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 193;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/imeiservices.fun.php";
$pagelimit = 200;
if ($stype == "server") {
    $whereserv = " server=1";
    $commonwhere = " and useasserver=1";
} else {
    $whereserv = " server=0";
    $commonwhere = " and useasserver=0";
}
$imeiOrders = getOrdersIMEI("", md5($id), "", "", "1");
$row = mysqli_fetch_assoc(dquery("select service_name from tbl_services_imei \nwhere id='" . $id . "'"));
if ($extract) {
    echo "<!--\n<ul id=\"tabmenu\"> \n    <li><a onclick=\"getContect('#tab','main2.php?page=imeiquickaccept','','','#tabcontent',true,'#main_loader');\" id=\"tab33\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n    <li><a   onclick=\"getContect('#tab','main2.php?page=imeiorder.new','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>    \n    <li><a onclick=\"getContect('#tab12','main2.php?page=quickreply','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["quickreply"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=imeiorder.replied','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["manualreply"];
    echo "</a></li>\n    <li><a  class=\"last\"  onclick=\"getContect('#tab12','main2.php?page=imeiorder.bulk','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["bulkreply"];
    echo "</a></li>        \n    <li><a ";
    if ($loaddefaultpage == "quickreply.php" || $loaddefaultpage == "imeiorder.verification.php") {
        echo "class='tabmenu_active'";
    }
    echo "   class='tabmenu_active'  onclick=\"getContect('#tab3','main2.php?page=imeiorder.verification','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab4','main2.php?page=imeiorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["orderhistory"];
    echo "</a></li>\n    <li><a  style=\"text-decoration: none;\" href=\"main2.php?page=imeiorder&laoddefaultpage=imeiorder.pending.php\" id=\"tab5\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["payment"];
    echo "</a></li>\n    <div style=\"clear: both;\"></div>\n</ul>\n--> <div id=\"tabcontent\">\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($extract) {
    $buf = "";
    $sql = dquery("SELECT `order_id`,`imei` FROM `tbl_order_imei`\n    where `service_id`='" . $id . "' and `verified`='1' and user_can_c=4 and " . $whereserv);
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= $row["order_id"] . "  : " . $row["imei"] . " &#10;-------------------------------&#10;";
    }
    echo "<textarea  rows=\"5\">\n";
    echo $buf;
    echo "</textarea>\n<br />\n";
} else {
    echo "<form id=\"replied\" name=\"replied\" method=\"post\">\n<div align=\"right\">\n    <input type=\"button\" name=\"extract\" onclick=\"load_subpage('main2.php?page=viewimeiorder.verif&id=";
    echo $id;
    echo "&extract=true','";
    echo $LNG["extractall"];
    echo "');\"     value=\"";
    echo $LNG["extractall"];
    echo "\" />\n</div>\n<br />\n";
    echo generate_token("form");
    echo "<table id=\"main_tbl\" >\n<thead>\n  <tr>\n        <th><input type=\"checkbox\" name=\"checkall\" onclick=\"CheckAll(this);\" /> </th>\n        <th>";
    echo $LNG["order"];
    echo "</th>\n        <th>";
    echo $LNG["servicename"];
    echo "</th>\n      ";
    if (!$supplieraccess) {
        echo "     \n            <th>";
        echo $LNG["date"];
        echo " </th> \n            <th>";
        echo $LNG["total"];
        echo " ";
        echo $LNG["credit"];
        echo " </th>\n      ";
    }
    echo "         \n        <th>\n        ";
    if ($stype == "server") {
        echo "            ";
        echo $LNG["qnt"];
        echo "        ";
    } else {
        echo "            ";
        echo $LNG["imei"];
        echo "        ";
    }
    echo "</th>\n        <th>";
    echo $LNG["username"];
    echo " </th>\n        <th>";
    echo $LNG["reply"];
    echo " </th> \n        <th><input type=\"checkbox\" name=\"reject\" onclick=\"RCheckAll(this);\" /><label> ";
    echo $LNG["reject"];
    echo "</label></th>\n        <th></th>\n  </tr>\n</thead> \n<tbody>   \n";
    foreach ($imeiOrders as $id => $Orders) {
        echo " <tr id=\"hide_";
        echo $id;
        echo "\">\n        <td><input type=\"checkbox\" name=\"select[]\" class=\"select\" value=\"";
        echo $id;
        echo "\" /></td>\n        <td>";
        echo $id;
        echo "</td>\n        <td>";
        echo $Orders["service"];
        echo "</td>\n        ";
        if (!$supplieraccess) {
            echo "    \n            <td>";
            echo $Orders["date"];
            echo "</td>     \n            <td>";
            echo round($Orders["credit"] - $Orders["discount"], $precision);
            echo " ";
            echo $Orders["code"];
            echo "</td>\n        ";
        }
        echo "          \n        <td>\n        ";
        if ($stype == "server") {
            echo "            ";
            echo $Orders["qnt"];
            echo "        ";
        } else {
            echo "            ";
            echo $Orders["imei"];
            echo "        ";
        }
        echo "        </td>\n        <td>";
        echo $Orders["username"];
        echo "</td> \n        <td><input type=\"text\" style=\"width:100px !important;\" name=\"reply[";
        echo $id;
        echo "]\" value=\"";
        echo $Orders["reply"];
        echo "\" /></td> \n        <td><input type=\"checkbox\"  name=\"reject[";
        echo $id;
        echo "]\" class=\"reject\" value=\"";
        echo $id;
        echo "\" ";
        if ($Orders["user_can_c"] == 3) {
            echo "checked";
        }
        echo " /></td>\n        <td></td>\n    </tr>\n    ";
    }
    echo "\n</tbody></table>\n<p align=\"center\" class=\"fixedbtn\">\n<input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"Reply Selected\" \n onclick=\"SubmitForm ('#replyorders','verification','#replied','#notification','true','#main_loader');\"/>\n \n <input type=\"button\" name=\"replyorderss\" id=\"replyorderss\" class=\"btn\"  value=\"Set Back Success\" \n onclick=\"SubmitForm ('#replyorderss','setbackimei','#replied','#notification','true','#main_loader');\"/>\n\n </p>\n</form>\n\n</div></div> \n<script>\nfunction CheckAll(o)\n{\n\t\tif(\$(o).is(\":checked\")){\n            \$('.select').prop({'checked':true});\n        }else{\n            \$('.select').prop({'checked':false});\n        }\n}\nfunction ACheckAll(o)\n{\n        if(\$(o).is(\":checked\")){\n            \$('.accept').prop({'checked':true});\n        }else{\n            \$('.accept').prop({'checked':false});\n        }\n\t\t \n}\nfunction RCheckAll(o)\n{\n\t\tif(\$(o).is(\":checked\")){\n            \$('.reject').prop({'checked':true});\n        }else{\n            \$('.reject').prop({'checked':false});\n        }\n}\n</script>\n";
}
if ($extract) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>