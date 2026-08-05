<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$msg = [];
if ($siteurl && $username && $password) {
    if ($siteurl == $config["site_address"]) {
        $username = preg_replace("/[^A-Za-z0-9]/", "", $username);
        $password = preg_replace("/[^A-Za-z0-9]/", "", $password);
        $password = md5(md5($password) . "9486");
        if (mysqli_num_rows(dquery("select id from tbl_admin where username='" . $username . "' and password='" . $password . "' "))) {
            $msg["status"] = "success";
            $msg["msg"] = "Login successfull";
        } else {
            $msg["status"] = "error";
            $msg["msg"] = "Wrong Username Password";
        }
    } else {
        $msg["status"] = "error";
        $msg["msg"] = "Wrong Site Address";
    }
} else {
    $msg["status"] = "error";
    $msg["msg"] = "Field Required";
}
echo json_encode($msg);

?>