<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
$id = $_GET["id"];
include_once ROOTDIR . "/includes/serverservices.fun.php";
$order = mysqli_fetch_assoc(dquery("select order_id,time,(select service_name from tbl_server_log where id=service_id) as service,\n(credit-discount) as cc,(select default_currency from tblUsers where id=user_id) as def,\n(select username from tblUsers where id=user_id) as user,reply,user_can_c,date from tbl_order_server where order_id='" . $id . "'"));
$sql = mysqli_fetch_assoc(dquery("select code from tbl_currencies where id='" . $order["def"] . "'"));
echo "<div id=\"notificationed\"></div>\n<div class=\"panel\">\n        <h2>Server Order Detail</h2>\n        <hr>\n        <table class=\"grid\">\n            <tr>\n                <td>#";
echo $LNG["id"];
echo " </td>\n                <td>#";
echo $order["order_id"];
echo " </td>\n            </tr>\n            <tr>\n                <td>";
echo $LNG["user"];
echo "</td>\n                <td>";
echo $order["user"];
echo "</td>\n            </tr>\n            <tr>\n                <td>";
echo $LNG["user"];
echo " ";
echo $LNG["cost"];
echo "</td>\n                <td>";
echo $order["cc"];
echo " [";
echo $sql["code"];
echo "]</td>\n            </tr>\n            <tr>\n                <td>";
echo $LNG["order"];
echo " ";
echo $LNG["on"];
echo "</td>\n                <td>";
echo date("d-m-Y H:i:s", $order["time"]);
echo "</td>\n            </tr>\n            <tr>\n                <td>";
echo $LNG["service"];
echo "</td>\n                <td>";
echo $order["service"];
echo "</td>\n            </tr>\n            <tr>\n                <td>";
echo $LNG["status"];
echo "</td>\n                <td>\n                ";
if ($order["user_can_c"] == 0) {
    echo "New";
} else {
    if ($order["user_can_c"] == 1) {
        echo "Accepted";
    } else {
        if ($order["user_can_c"] == 3) {
            echo "Rejected";
        } else {
            if ($order["user_can_c"] == 4) {
                echo "Replied";
            }
        }
    }
}
echo "                </td>\n            </tr>\n        </table>\n        <hr />\n\n <div class=\"action\">\n        <div class=\"panel\">\n        <form method=\"post\" id=\"frmreply\">\n<input type=\"hidden\" name=\"md5id\" value=\"";
echo md5($order["order_id"]);
echo "\" />\n";
if ($verify) {
    echo "<input type=\"hidden\" name=\"verify\" value=\"true\" />\n    ";
}
echo "\t <h2>Reply Server Order</h2>\n            <ol>\n                <li class=\"field\">\n                    <label>";
echo $LNG["reply"];
echo ":\n                        <input type='text' name='reply' value=\"";
echo $order["reply"];
echo "\" />\n                    </label>\n                </li>\n                <li class=\"field\">\n                    <label>&nbsp;\n                        <input type='checkbox' id=\"reject\" ";
if ($order["user_can_c"] == 3) {
    echo "checked='checked'";
}
echo " name='reject' /> Reject Order\n                    </label>\n                </li>\n            </ol>\n            <div class=\"panel\">\n<p><a  id=\"btnsave\" onclick=\"SubmitForm ('#btnsave','m.editserverorder','#frmreply','#notificationed','false','');\"\n class=\"btn\">Reply</a></p>\n            </div>\n        </form>\n     </div>\n</div>\n</div>\n\n\n";

?>