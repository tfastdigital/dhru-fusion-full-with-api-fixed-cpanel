<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 418;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/serverservices.fun.php";
include_once ROOTDIR . "/includes/comm.inc.php";
echo "  \n<div id=\"notification\"></div> \n<div id=\"content\">\n<div id=\"content_padded\">\n";
$defaultcurrency = mysqli_fetch_assoc(dquery("SELECT id from `tbl_currencies` where `default`='1'"));
$result = dquery("SELECT id,user_id,(select username from tblUsers where id=user_id) as username,subscribe_start,subscribe_end FROM tbl_subscribers WHERE service_id='" . $id . "' AND type='tbl_server_log'");
echo "<form id=\"frmedituser\" name=\"\" method=\"post\" enctype=\"multipart/form-data\">\n<input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n";
echo generate_token("form");
echo "<table id=\"main_tbl\">\n<thead><tr>\n<th>";
echo $LNG["id"];
echo "</th>\n<th>";
echo $LNG["username"];
echo "</th>\n<th>";
echo $LNG["subscribed"];
echo " ";
echo $LNG["date"];
echo "</th>\n<th>";
echo $LNG["subscription"];
echo " ";
echo $LNG["end"];
echo "</th>\n<th>";
echo $LNG["remain"];
echo " ";
echo $LNG["days"];
echo "</th>\n<th>";
echo $LNG["edit"];
echo "</th>\n</thead>\n<tbody>\n";
while ($row = mysqli_fetch_assoc($result)) {
    $cur = time();
    echo "<tr>\n<td>";
    echo $row["user_id"];
    echo "</td>\n<td>";
    echo $row["username"];
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_start"]);
    echo "</td>\n<td>";
    echo date("Y-m-d", $row["subscribe_end"]);
    echo "</td>\n<td>";
    if ($cur <= $row["subscribe_end"]) {
        echo intval(($row["subscribe_end"] - $cur) / 86400);
    } else {
        echo "Expired";
    }
    echo "</td>\n<td><a class=\"editdata\" onclick=\"load_subpage('includes/pages/editsubscriber.php?id=";
    echo $row["id"];
    echo "','";
    echo $LNG["edit"];
    echo "');\">";
    echo $LNG["edit"];
    echo "</a></td>\n</tr>\n";
}
echo "</tbody>\n</table>\n\n\n</form></div></div>";
$fileverioncheck = "6.1.0";

?>