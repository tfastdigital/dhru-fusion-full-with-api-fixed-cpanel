<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

require_once ROOTDIR . "/comm.php";
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/products.fun.php";
$productDetails = getProducts("", "", "", true, true);
if ($close) {
    $sql = dquery("select user_id,service_id,order_id from tbl_order_product\n    where user_can_c='8' and service_id='" . $id . "' and winner='1'");
    while ($r = mysqli_fetch_assoc($sql)) {
        dquery("update tbl_order_product set user_can_c='0' where order_id='" . $r["order_id"] . "'");
    }
    $sql = dquery("select user_id,service_id,order_id from tbl_order_product\n    where user_can_c='8' and service_id='" . $id . "' and winner='0'");
    while ($r = mysqli_fetch_assoc($sql)) {
        dquery("update tbl_order_product set user_can_c='4' where order_id='" . $r["order_id"] . "'");
    }
    dquery("update tbl_products set draw='0' where id='" . $id . "'");
    if ($ina == "true") {
        dquery("update tbl_products set active='0' where id='" . $id . "'");
    }
}
$clos = mysqli_fetch_assoc(dquery("select draw from tbl_products where id='" . $id . "'"));
if (!$clos["draw"]) {
    echo "<div align='center'><h2>Deal Closed !</h2></div>";
}
if ($winner) {
    dquery("update tbl_order_product set winner='1' where order_id='" . $winner . "'");
}
if ($remove) {
    dquery("update tbl_order_product set winner='0' where order_id='" . $remove . "'");
}
$porder = dquery("SELECT *,\n(select username from tblUsers where id=user_id) as user,\n(select email from tblUsers where id=user_id) as email FROM \n`tbl_order_product` where user_can_c='8' and service_id='" . $id . "' and winner='0'");
echo "<style>\n.selecteds{\n    background-color: #F5FAA5;\n    color:  black;\n}\n</style>\n<script>\nfunction findPos(obj) {\n\tvar curtop = 0;\n\tif (obj.offsetParent) {\n\t\tdo {\n\t\t\tcurtop += obj.offsetTop;\n\t\t} while (obj = obj.offsetParent);\n\treturn [curtop];\n\t}\n}\nfunction SelRandWin(){\n    var obs=document.getElementsByTagName('tr');\n    var news=new Array();\n    for(var i=0;i<obs.length;i++){\n        if(obs[i].id=='winds'){\n            news[i]=obs[i];\n            obs[i].removeAttribute(\"class\");\n        }\n    }\n\n    var sel = news[Math.floor(Math.random()*news.length)]\n    sel.setAttribute('class','selecteds');\n    window.scroll(0,findPos(sel));\n}\n</script>\n<div id=\"content\"> \n<div id=\"content_padded\">\n<div id=\"notification\"></div>\n";
if ($clos["draw"]) {
    echo "<div style=\"float: right;\">\n<input type=\"button\" name=\"selectwin\" onclick=\"SelRandWin();\" value=\"Select Random Winner\" />\n<input type=\"button\" name=\"closedeal\" onclick=\"javascript: redirectedit('viewdraworder','";
    echo $id;
    echo "&close=true&ina='+document.getElementById('inact').checked);\"  value=\"";
    echo $LNG["close"];
    echo " ";
    echo $LNG["deal"];
    echo "\" />\n<input type=\"checkbox\" name=\"inactivate\" id=\"inact\" value=\"1\" /><label for=\"inact\">And Inactive Product</label>\n</div>\n";
}
echo "\n<div style=\"clear: both;\"></div>\n";
$win = dquery("SELECT *,\n(select username from tblUsers where id=user_id) as user,\n(select email from tblUsers where id=user_id) as email FROM \n`tbl_order_product` where user_can_c='8' and service_id='" . $id . "' and winner='1'");
if (mysqli_num_rows($win)) {
    echo "<h4>Winner List</h4>\n<table id=\"main_tbl\" >\n<thead>\n<th>";
    echo $LNG["order"];
    echo "</th>\n<th>";
    echo $LNG["date"];
    echo "</th>\n<th>";
    echo $LNG["user"];
    echo "</th>\n<th align=\"right\"><span style=\"float: right; padding-right: 65px;\">";
    echo $LNG["action"];
    echo "</span></th>\n</thead>\n<tbody>\n";
    while ($row = mysqli_fetch_assoc($win)) {
        echo "<tr>\n    <td><strong>";
        echo $LNG["order"];
        echo " : #";
        echo $row["order_id"];
        echo " ";
        echo $row["buyadvance"] ? "[" . $LNG["preorder"] . "]" : "";
        echo "</strong></td>\n    <td>";
        echo $row["date"];
        echo "</td>\n    <td>";
        echo $row["user"];
        echo " [";
        echo $row["email"];
        echo "]</td>\n    <td><span style=\"float: right; font-size: 20px; line-height: 23px;\">\n    <a style=\"font-size: 13px;color: #666;\"\n     onclick=\"redirectedit('viewdraworder','";
        echo $id;
        echo "&remove=";
        echo $row["order_id"];
        echo "')\"><strong>";
        echo $LNG["remove"];
        echo " ";
        echo $LNG["winner"];
        echo "</strong></a> &nbsp;&nbsp;&nbsp; </span></td>\n</tr>\n";
    }
    echo "</tbody>\n</table>\n<br /><br />\n";
}
if (!$clos["draw"]) {
    exit;
}
echo "\n<div style=\"clear: both;\"></div>\n<form method=\"post\" name=\"myfrom\">\n<input type=\"hidden\" name=\"loaddefaultpage\"  value=\"productorder.new.php\" />\n<h4>Subscriber List</h4>\n<table id=\"main_tbl\" >\n<thead>\n<th>";
echo $LNG["order"];
echo "</th>\n<th>";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["user"];
echo "</th>\n<th align=\"right\"><span style=\"float: right; padding-right: 65px;\">";
echo $LNG["action"];
echo "</span></th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($porder)) {
    echo "<tr id=\"winds\">\n    <td><strong>";
    echo $LNG["order"];
    echo " : #";
    echo $row["order_id"];
    echo " ";
    echo $row["buyadvance"] ? "[" . $LNG["preorder"] . "]" : "";
    echo "</strong></td>\n    <td>";
    echo $row["date"];
    echo "</td>\n    <td>";
    echo $row["user"];
    echo " [";
    echo $row["email"];
    echo "]</td>\n    <td><span style=\"float: right; font-size: 20px; line-height: 23px;\">\n    <a style=\"font-size: 13px;color: #666;\"\n     onclick=\"redirectedit('viewdraworder','";
    echo $id;
    echo "&winner=";
    echo $row["order_id"];
    echo "')\"><strong>";
    echo $LNG["select_"];
    echo " ";
    echo $LNG["winner"];
    echo "</strong></a> &nbsp;&nbsp;&nbsp; </span></td>\n</tr>\n";
}
echo "</tbody>\n</table>\n<input type=\"hidden\" value=\"viewdraworder.php\" name=\"loaddefaultpage\"/>\n</form>\n</div></div> ";
$fileverioncheck = "6.1.0";

?>