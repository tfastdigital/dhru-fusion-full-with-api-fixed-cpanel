<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 322;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/serverservices.fun.php";
$serverOrders = getOrdersServer("", md5($id), "", "", "1");
$row = mysqli_fetch_assoc(dquery("select service_name from tbl_server_log where id='" . $id . "'"));
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
if ($extracts) {
    echo "<ul id=\"tabmenu\"> \n<li><a  ";
    if (!$extracts) {
        echo "class='tabmenu_active' ";
    }
    echo " onclick=\"getContect('#tab','main2.php?page=serverquickaccept','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["neworder"];
    echo "</a>\n<ul>\n    <li><a onclick=\"getContect('#tab','main2.php?page=serverquickaccept','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab','main2.php?page=serverorder.new','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>\n</ul>\n</li> \n\n<li><a onclick=\"getContect('#tab12','main2.php?page=quickserverreply','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["replyaccepted"];
    echo "</a>\n<ul>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=quickserverreply','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["quickreply"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=serverorder.replied','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["manualreply"];
    echo "</a></li>\n</ul></li>\n\n<li><a ";
    if ($extracts) {
        echo "class='tabmenu_active' ";
    }
    echo " onclick=\"getContect('#tab3','main2.php?page=serverorder.verification','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n<li><a onclick=\"getContect('#tab4','main2.php?page=serverorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["orderhistory"];
    echo "</a></li>\n<li><a\nstyle=\"text-decoration:none;\"\nhref='main2.php?page=serverorder&laoddefaultpage=serverorder.pending.php'\n id=\"tab5\" >";
    echo $LNG["pending"];
    echo " ";
    echo $LNG["order"];
    echo "</a></li>\n\n<div style=\"clear: both;\"></div>\n</ul> <div id=\"tabcontent\">\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
if ($extracts) {
    $buf = "";
    $sql = dquery("SELECT `order_id`,`server`,(select `service_name` from \n    tbl_server_log where id=service_id) as `service` FROM `tbl_order_server` where\n     `service_id`='" . $id . "' and `verified`='1' and user_can_c=4");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= $row["order_id"] . "  : " . $row["service"] . " &#10;----------------------------------------------------------&#10;";
    }
    echo "<textarea class='textarea large' rows=\"5\">\n";
    echo $buf;
    echo "</textarea>\n";
}
echo "<div align=\"right\">\n    <input type=\"button\" name=\"extract\" onclick=\"redirectedit('viewserverorder.verif','&id='+";
echo $id;
echo "+'&extracts=true');\" value=\"";
echo $LNG["extractall"];
echo "\" />\n    <br /><br />\n</div>\n<form id=\"replied\" name=\"replied\" method=\"post\" >\n";
echo generate_token("form");
echo "<table id=\"main_tbl\" > \n<thead>\n  <tr>  <th>\n<!--\n<input type=\"checkbox\" name=\"checkall\"  onclick=\"CheckAll();\" />\n-->\n </th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n        <th>";
echo $LNG["date"];
echo "</th>\n        <th>";
echo $LNG["total"];
echo " ";
echo $LNG["credit"];
echo " </th>\n        <th>";
echo $LNG["username"];
echo " </th>\n        <th>";
echo $LNG["reply"];
echo " </th> \n        <th><input type=\"checkbox\" name=\"reject\" onclick=\"RCheckAll();\" />";
echo $LNG["reject"];
echo "</th>\n  </tr>\n</thead> \n<tbody>    \n";
foreach ($serverOrders as $id => $Orders) {
    echo "    <tr id=\"hide_";
    echo $id;
    echo "\">\n        <td><input type=\"checkbox\" name=\"select[]\" id=\"select\" value=\"";
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
    echo $Orders["username"];
    echo "</td>\n        <td><input type=\"text\" name=\"reply[";
    echo $id;
    echo "]\" value=\"";
    echo $Orders["reply"];
    echo "\" /></td> \n        <td><input type=\"checkbox\" name=\"reject[";
    echo $id;
    echo "]\" id=\"reject\" value=\"";
    echo $id;
    echo "\" /></td>\n    </tr>\n    ";
}
echo "</tbody>\n</table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"Reply Selected\" \n onclick=\"SubmitForm ('#replyorders','verificationserver','#replied','#notification','true','#main_loader');\"/></p>\n</form></div></div> \n<script>\nfunction CheckAll()\n{    \n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{    \n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=true;\n\t\t\t}\n\t\t}\n}\n</script>\n";
if ($extract) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>