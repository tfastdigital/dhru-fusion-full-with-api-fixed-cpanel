<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$parameter = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["parameter"]);
$value = preg_replace("/[^0-9a-zA-Z ]/i", "", $_POST["values"]);
$extra = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["extra"]);
$isveri = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
include ROOTDIR . "/includes/serverservices.fun.php";
$sql = mysqli_fetch_assoc(dquery("select id from tbl_admin where username='" . $username . "'"));
if ($extra == 1) {
    if (rejectServer(md5($parameter), $value, $sql["id"], "", "")) {
        if ($isveri == 1) {
            dquery("UPDATE tbl_order_server SET verified=2 WHERE order_id='" . $parameter . "'");
        }
        $reply["STATUS"] = "SUCCESS";
    } else {
        $reply["STATUS"] = "ERROR";
    }
} else {
    if (replySuccessServer(md5($parameter), $value, $sql["id"], "", "")) {
        if ($isveri == 1) {
            dquery("UPDATE tbl_order_server SET verified=2 WHERE order_id='" . $parameter . "'");
        }
        $reply["STATUS"] = "SUCCESS";
    } else {
        $reply["STATUS"] = "ERROR";
    }
}
$reply["DATA"] = $output;
$reply["VERSION"] = $api_version;
echo json_encode($reply);

?>