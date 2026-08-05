<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "\n";
$pageid = 405;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/serverservices.fun.php";
include_once ROOTDIR . "/includes/comm.inc.php";
echo "  \n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n";
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$result = dquery("SELECT user_id,username,(select groupname from tbl_client_group where id=client_group) as groupname,service_id,service_name,discount,credit,default_currency FROM `tbl_discount_server_log`,tbl_server_log,tblUsers where tblUsers.id=tbl_discount_server_log.user_id and tbl_server_log.id=tbl_discount_server_log.service_id and service_id=" . $id . " and discount!='0'");
echo "<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead><tr><th>";
echo $LNG["username"];
echo "</th><th>";
echo $LNG["groupname"];
echo "</th>\n";
$sql = dquery("SELECT `code` from `tbl_currencies`");
while ($row = mysqli_fetch_assoc($sql)) {
    echo "<th  width=\"80px\"><div align=\"center\">";
    echo $row["code"];
    echo "</div></th>";
}
echo " </tr></thead>\n<tbody>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td><a onclick=\"getContect('#tab14','main2.php?page=edituser.serverservice','";
    echo $row["user_id"];
    echo "','','#tabcontent',true,'#main_loader');\">";
    echo $row["username"];
    echo "</a></td><td>";
    echo $row["groupname"];
    echo "</td>\n\n";
    $sql1 = dquery("SELECT `code`,id from `tbl_currencies`");
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        if ($row["default_currency"] == $row1["id"]) {
            $priceset = mysqli_fetch_assoc(dquery("select credit from tbl_server_credit where service_id=" . $id . " and currency_id=" . $row1["id"]));
            if ($priceset["credit"]) {
                echo "                <td><div align=\"center\"><span style=\"text-decoration:line-through; color: red;\">";
                echo $priceset["credit"];
                echo "</span> ";
                echo $priceset["credit"] - $row["discount"];
                echo "</div></td>\n            ";
            } else {
                echo "                <td><div align=\"center\"><span style=\"text-decoration:line-through; color: red;\">";
                echo convertCurrency($row["credit"], $defaultcurrency["id"], $row["default_currency"]);
                echo "</span> ";
                echo convertCurrency($row["credit"], $defaultcurrency["id"], $row["default_currency"]) - $row["discount"];
                echo "</div></td>\n            ";
            }
        } else {
            echo "        <td><div align=\"left\"></div></td>\n    ";
        }
    }
    echo "</tr>\n";
}
echo "</tbody>\n</table>\n\n\n</form></div></div> \n\n<div id=\"page_info\" classs=\"page_info\">\n\t<li>List all discounted user list currency wise</li>\n</div>";
$fileverioncheck = "6.1.0";

?>