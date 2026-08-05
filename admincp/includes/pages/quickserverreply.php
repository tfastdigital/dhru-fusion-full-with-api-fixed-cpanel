<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 370;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/serverservices.fun.php";
$pagelimit = 1000;
if ($config["orderdisplay"] == 2) {
    $default_order_type = "ASC";
} else {
    $default_order_type = "DESC";
}
$serverOrders = getOrdersServer("accepted", "", "", "", "", $default_order_type);
$_SESSION["once_accepted"] = true;
if ($extract) {
    echo "<!--\n<ul id=\"tabmenu\"> \n<li><a   onclick=\"getContect('#tab','main2.php?page=serverquickaccept','','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["neworder"];
    echo "</a>\n<ul>\n    <li><a onclick=\"getContect('#tab','main2.php?page=serverquickaccept','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["quickaccept"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab','main2.php?page=serverorder.new','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["manualaccept"];
    echo "</a></li>\n</ul>\n</li> \n<li><a class='tabmenu_active' onclick=\"getContect('#tab12','main2.php?page=quickserverreply','','','#tabcontent',true,'#main_loader');\" id=\"tab12\" >";
    echo $LNG["replyaccepted"];
    echo "</a>\n<ul>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=quickserverreply','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["quickreply"];
    echo "</a></li>\n    <li><a onclick=\"getContect('#tab12','main2.php?page=serverorder.replied','','','#tabcontent',true,'#main_loader');\" >";
    echo $LNG["manualreply"];
    echo "</a></li>\n</ul>\n</li>\n<li><a onclick=\"getContect('#tab3','main2.php?page=serverorder.verification','','','#tabcontent',true,'#main_loader');\" id=\"tab3\" >";
    echo $LNG["verificationorder"];
    echo "</a></li>\n<li><a onclick=\"getContect('#tab4','main2.php?page=serverorder.history','','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["orderhistory"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul>\n--> \n\n<div id=\"tabcontent\">\n";
}
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<h2>    \n    <span class=\"groupstabesheadertext\">Quick Reply</span>\n  </h2>\n  \n";
if ($extract) {
    $buf = "";
    $sql = dquery("SELECT `order_id`,(select `service_name` from tbl_server_log where id=service_id) as `service` FROM `tbl_order_server` where `user_can_c`='1'");
    while ($row = mysqli_fetch_assoc($sql)) {
        $buf .= $row["order_id"] . "  : " . $row["service"] . "&#10;";
    }
    echo "<br />\n<textarea class=\"textarea large\" rows=\"5\">\n";
    echo $buf;
    echo "</textarea><br />\n";
} else {
    echo "         \n         \n        <form method=\"post\" style=\"float: right;\">  \n        \n                  \n            <input type=\"hidden\" name=\"loaddefaultpage\" value=\"quickserverreply.php\" /> \n            <select name=\"service\">\n            <option value=\"\">Select Serivce</option>\n            ";
    $sql = dquery("SELECT service_id,(SELECT service_name FROM tbl_server_log WHERE id=service_id) AS service from tbl_order_server where user_can_c='1' group by service_id");
    while ($rows = mysqli_fetch_assoc($sql)) {
        echo "            <option value=\"";
        echo $rows["service_id"];
        echo "\" >";
        echo $rows["service"];
        echo "</option>\n            ";
    }
    echo "            </select>\n            \n            <input class=\"btn btn-info\" type=\"submit\" name=\"finder\" value=\"";
    echo $LNG["search"];
    echo "\" />\n            <br />\n              ";
    echo $LNG["quickreplyinfo"];
    echo "     \n                    \n            </form>\n        \n        \n        \n        \n        <div class=\"clear\"></div>\n     \n        <form id=\"replied\" name=\"replied\" method=\"post\" >\n            ";
    echo generate_token("form");
    echo "            <table id=\"main_tbl\" >\n            <thead>\n              <tr>\n                   \n                    <th>";
    echo $LNG["servicename"];
    echo "</th>\n                    <th>";
    echo $LNG["date"];
    echo "</th>\n                    <th>";
    echo $LNG["total"] . " " . $LNG["credit"];
    echo "</th>\n                    <th>";
    echo $LNG["qnt"];
    echo " </th>\n                    <th>";
    echo $LNG["username"];
    echo " </th>\n                    <th>";
    echo $LNG["reply"];
    echo " </th> \n                    <th></th>\n              </tr>\n            </thead> \n            <tbody> \n                        \n                        \n            ";
    if ($serverOrders) {
        foreach ($serverOrders as $id => $Orders) {
            if (!($finder && $service && $Orders["service_id"] != $service)) {
                echo "                <tr id=\"hide_";
                echo $id;
                echo "\">\n                  <input type=\"hidden\" name=\"select[]\" id=\"select\" value=\"";
                echo $id;
                echo "\" />\n                    <td>";
                echo $Orders["service"];
                echo "</td>\n                    <td>";
                echo $Orders["date"];
                echo "</td>\n                    <td>";
                echo round($Orders["credit"] - $Orders["discount"], $precision);
                echo " ";
                echo $Orders["code"];
                echo "</td>\n                    <td>";
                echo $Orders["qnt"];
                echo "</td>\n                    <td>";
                echo $Orders["username"];
                echo "</td>\n                    <td><input type=\"text\" name=\"reply[";
                echo $id;
                echo "]\" style=\"width: 200px;\" /></td> \n                    <td></td>\n                </tr>\n                ";
            }
        }
    }
    echo "            \n            </tbody></table>\n            <p  class=\"fixedbtn\"><input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
    echo $LNG["reply"];
    echo " ";
    echo $LNG["selected"];
    echo "\" \n             onclick=\"SubmitForm ('#replyorders','quickserverreplied','#replied','#notification','true','#main_loader');\"/>\n             \n             <input type=\"button\" class=\"btn btn-default floatright\" name=\"extract\" onclick=\"load_subpage('main2.php?page=quickserverreply&extract=true','";
    echo $LNG["extractall"];
    echo "');\" value=\"";
    echo $LNG["extractall"];
    echo "\" />\n             \n             </p>\n            </form>\n\n    ";
}
echo "\n\n\n\n\n\n</div>\n\n</div></div> \n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction RCheckAll()\n{\n\t\tvar i=document.replied.reject.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.reject[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.reject[k].checked=true;\n\t\t\t}\n\t\t}\n}\n</script>";
if ($extract) {
    echo "</div>\n";
}
$fileverioncheck = "6.1.0";

?>