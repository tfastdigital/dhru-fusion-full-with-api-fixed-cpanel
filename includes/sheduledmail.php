<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
require "../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
include ROOTDIR . "/includes/mail.fun.php";
if (!$config["mailperbatch"]) {
    $config["mailperbatch"] = 50;
}
if (trim($config["cronpassword"]) && trim($cronpasscode) != trim($config["cronpassword"])) {
    exit("Try after 2.0 hour");
}
$sm = dquery("select * from tbl_sheduledmail order \nby priority DESC LIMIT " . $config["mailperbatch"]);
while ($r = mysqli_fetch_assoc($sm)) {
    sendMail(999, $r["userid"], "", "", "", "", "", "", "", "", "", "", "", $r["id"]);
}

?>