<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">IP Search</a></li>\n</ul>\n";
$pageid = 529;
checkPagePermission($pageid);
echo "<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n <div  class=\"groupstabes\" >\n  <h2>    \n    <span class=\"groupstabesheadertext\">IP Search</span> \n  </h2>\n";
echo generate_token("form");
echo "\n<div>\n <form id=\"frm\" name=\"\" method=\"post\">\n        <table class=\"form\">\n            <tr>\n                <td class=\"fieldlabel\">\n<input type=\"text\" name=\"ip\" id=\"ip\"\nautocomplete=\"off\"  value=\"\" placeholder=\"IP Search\"/>\n </td><td class=\"fieldarea\">\n<input type=\"submit\" class=\"addFromgallery button\" name=\"search\"\n  style=\"background-color: #0a0a0a !important;\"      value=\"";
echo $LNG["search"];
echo "\"/>\n               </td>\n               \n            </tr>\n        </table>            \n </form> \n ";
if ($search && $ip) {
    echo " <table id=\"main_tbl\" style=\"display: table;\">\n<thead><tr><th>";
    echo $LNG["search"];
    echo " ";
    echo $LNG["result"];
    echo "</th><th><div align=\"right\">";
    echo $LNG["action"];
    echo "</div></th></tr></thead>\n<tbody>\n";
    $gresult = dquery("select id,username from tblUsers where last_login_ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>" . $row["username"] . " - Last Login</td><td align=right>-</td></tr>";
    }
    $gresult = dquery("select id,description from tbl_activity_log where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>" . $row["description"] . "</td><td align=right>\n    <a href='javascript:load_fromsubpage(\"activitylog\",\"Activity Log\");'>View</a></td></tr>";
    }
    $gresult = dquery("select order_id,(select service_name \nfrom tbl_services_imei where id=user_id) as service from tbl_order_imei where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>IMEI Order : " . $row["service"] . "</td><td align=right>\n<a href='javascript:load_fromsubpage(\"imeiorder\",\"IMEI Order\");'>View</a></td></tr>";
    }
    $gresult = dquery("select order_id,(select service_name \nfrom tbl_services_file where id=user_id) as service from tbl_order_file where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>File Order : " . $row["service"] . "</td><td align=right>\n<a href='javascript:load_fromsubpage(\"fileorder\",\"File Order\");'>View</a></td></tr>";
    }
    $gresult = dquery("select order_id,(select service_name \nfrom tbl_server_log where id=user_id) as service from tbl_order_server where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>Server Order : " . $row["service"] . "</td><td align=right>\n<a href='javascript:load_fromsubpage(\"serverorder\",\"Server Order\");'>View</a></td></tr>";
    }
    $gresult = dquery("select order_id,(select service_name \nfrom tbl_products where id=user_id) as service from tbl_order_product where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>Product Order : " . $row["service"] . "</td><td align=right>\n<a href='javascript:load_fromsubpage(\"productorder\",\"Product Order\");'>View</a></td></tr>";
    }
    $gresult = dquery("select id,(select username \nfrom tblUsers where id=uid) as user,uid from tbl_statement_user where ip like '" . $ip . "'");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>" . $row["user"] . " Statement</td><td align=right>\n<a href='javascript:load_fromsubpage(\"edituser.statement&id=" . $row["uid"] . "\",\"User Statement\");'>View</a></td></tr>";
    }
    $gresult = dquery("select id,tid,subject,(select username \nfrom tblUsers where id=uid) as user,uid from tbl_support_tickets where ip like '" . $ip . "' group by tid");
    while ($row = mysqli_fetch_assoc($gresult)) {
        echo "<tr><td>#" . $row["tid"] . " " . $row["subject"] . "</td><td align=right>\n<a href='javascript:load_fromsubpage(\"support.open&id=4\",\"Support Ticket\");'>View</a></td></tr>";
    }
    echo "\n\n</tbody></table>\n";
}
echo "</div>\n           \n</div> \n</div>\n";
$fileverioncheck = "6.1.0";

?>