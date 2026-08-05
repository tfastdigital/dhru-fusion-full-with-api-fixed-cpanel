<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 428;
checkPagePermission($pageid);
if ($gat && $id) {
    echo "<ul id=\"tabmenu\"> \n  \n    <li><a class=\"tabmenu_active\" onclick=\"getContect('#tab','main2.php?page=shippingateway.list','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab\" >";
    echo $LNG["shipping"];
    echo " ";
    echo $LNG["services"];
    echo " ";
    echo $LNG["list"];
    echo "</a></li> \n   <!-- <li><a onclick=\"getContect('#tab1','main2.php?page=shippingateway.conf','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab1\" >";
    echo $LNG["shipping"];
    echo " ";
    echo $LNG["gateway"];
    echo " ";
    echo $LNG["settings"];
    echo "</a></li>\n   -->\n    <li><a onclick=\"getContect('#tab4','main2.php?page=shippingatewaycustom','";
    echo $id;
    echo "','','#tabcontent',true,'#main_loader');\" id=\"tab4\" >";
    echo $LNG["customgateway"];
    echo "</a></li>\n<div style=\"clear: both;\"></div>\n</ul><div id=\"tabcontent\">\n";
}
echo "<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\" >       \n";
if ($id && $gat) {
    dquery("UPDATE tbl_shipping_services SET status=IF(status=0,1,0) WHERE md5(gateway)='" . $gat . "' AND md5(value)='" . $id . "'");
}
$req = dquery("SELECT distinct gateway FROM `tbl_shipping_services`");
while ($data = mysqli_fetch_assoc($req)) {
    echo "<div class=\"groupstabes\" >\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
    echo $data["gateway"];
    echo "</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<table id=\"main_tbl\" >";
    $req1 = dquery("SELECT `value`,`status` FROM `tbl_shipping_services` WHERE `gateway`='" . $data["gateway"] . "'");
    while ($data1 = mysqli_fetch_assoc($req1)) {
        echo "<tr>";
        echo "<td>" . $data1["value"] . "</td>";
        if ($data1["status"]) {
            $string = "<span class='textgreen'>" . $LNG["active"] . "</span>";
        } else {
            $string = "<span class='textred'>" . $LNG["inactive"] . "</span>";
        }
        echo "<td align='right' ><a class='default_dg_a2' href=\"javascript:reloadcurrent('shippingateway.list','" . md5($data1["value"]) . "&gat=" . md5($data["gateway"]) . "')\"> " . $string . " </a></td>";
        echo "</tr>";
    }
    echo "</table></div></div>\n \n";
}
echo "</div></div>\n";
if ($gat && $id) {
    echo "</div> \n";
}
if (!$fusionlite && $config["wikihelp"]) {
    echo " <div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Shipping-Gateway/?aid=15&cid=2&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a></div> ";
}
$fileverioncheck = "6.1.0";

?>