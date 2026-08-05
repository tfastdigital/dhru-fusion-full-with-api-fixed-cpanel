<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 36;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
include ROOTDIR . "/includes/serverservices.fun.php";
$pagelimit = 1000;
if ($config["orderdisplay"] == 2) {
    $orderby = "  ASC";
} else {
    $orderby = "  DESC";
}
$serverOrders = getOrdersServer("accepted", "", "", "", "", $orderby);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n<h2>\n    <span class=\"groupstabesheadertext\">Manual Reply</span>\n  </h2> <br />\n\n<form id=\"replied\" name=\"replied\" method=\"post\" >\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead>\n  <tr>\n        <th><input type=\"checkbox\" name=\"checkall\"  onclick=\"CheckAll();\" /></th>\n        <th>";
echo $LNG["servicename"];
echo "</th>\n        <th>";
echo $LNG["date"];
echo "</th>\n        <th>";
echo $LNG["total"] . " " . $LNG["credit"];
echo "</th>\n        <th>";
echo $LNG["qnt"];
echo " </th>\n        <th>";
echo $LNG["username"];
echo " </th>\n        <th>";
echo $LNG["reply"];
echo " </th>\n        <th><input type=\"checkbox\" name=\"reject\"  onclick=\"RCheckAll(this);\" /><label> ";
echo $LNG["reject"];
echo "</label></th>\n        <th></th>\n  </tr>\n</thead>\n<tbody>\n";
if ($serverOrders) {
    foreach ($serverOrders as $id => $Orders) {
        echo "        <tr id=\"hide_";
        echo $id;
        echo "\">\n            <td><input type=\"checkbox\" name=\"select[]\" id=\"select\" value=\"";
        echo $id;
        echo "\" /></td>\n            <td>";
        echo $Orders["service"];
        echo "</td>\n            <td>";
        echo $Orders["date"];
        echo "</td>\n            <td>";
        echo round($Orders["credit"] - $Orders["discount"], $precision);
        echo " ";
        echo $Orders["code"];
        echo "</td>\n            <td>";
        echo $Orders["qnt"];
        echo "</td>\n            <td>";
        echo $Orders["username"];
        echo "</td>\n            <td><input type=\"text\" style=\"width:200px\" name=\"reply[";
        echo $id;
        echo "]\" /></td>\n            <td><input type=\"checkbox\" name=\"reject[";
        echo $id;
        echo "]\" class=\"reject\" value=\"";
        echo $id;
        echo "\" /></td>\n            <td></td>\n        </tr>\n        ";
    }
}
echo "</tbody></table>\n<p align=\"center\" class=\"fixedbtn\"><input type=\"button\" name=\"replyorders\" id=\"replyorders\" class=\"btn\"  value=\"";
echo $LNG["reply"];
echo " ";
echo $LNG["selected"];
echo "\"\n onclick=\"SubmitForm ('#replyorders','serverreplied','#replied','#notification','true','#main_loader');\"/></p>\n</form></div></div>\n<script>\nfunction CheckAll()\n{\n\t\tvar i=document.replied.select.length;\n\t\tvar k;\n\t\tfor (k=0 ; k < i; k++)\n\t\t{\n\t\t\tif(document.replied.select[k].checked==true)\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=false;\n\t\t\t}\n\t\t\telse\n\t\t\t{\n\t\t\t\tdocument.replied.select[k].checked=true;\n\t\t\t}\n\t\t}\n}\nfunction ACheckAll(o)\n{\n        if(\$(o).is(\":checked\")){\n            \$('.accept').prop({'checked':true});\n        }\n        else{\n            \$('.accept').prop({'checked':false});\n        }\n\n}\nfunction RCheckAll(o)\n{\n\t\tif(\$(o).is(\":checked\")){\n            \$('.reject').prop({'checked':true});\n        }\n        else{\n            \$('.reject').prop({'checked':false});\n        }\n}\n</script>";
$fileverioncheck = "6.1.0";

?>