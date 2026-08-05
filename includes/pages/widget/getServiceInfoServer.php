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
require "../includes/fun.inc.php";
require "../includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
if ($data = mysqli_fetch_assoc(dquery("SELECT `info` FROM `tbl_server_log` WHERE md5(id)='" . $serviceid . "'"))) {
    echo $data["info"];
}

?>