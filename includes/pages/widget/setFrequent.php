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
require ROOTDIR . "/includes/clients.fun.inc.php";
$serviceid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $serviceid);
if (isset($_SESSION["uid"])) {
    $sql = mysqli_fetch_assoc(dquery("select imeifrequent\r\n    from tblUsers where id='" . $_SESSION["uid"] . "'"));
    $s = explode(",", $sql["imeifrequent"]);
    $flag = true;
    foreach ($s as $k => $v) {
        if ($v == $serviceid) {
            $flag = false;
            if ($remove) {
                unset($s[$k]);
            }
        }
    }
    if ($flag) {
        $s[] = $serviceid;
    }
    $services = implode(",", $s);
    $services = trim($services, ",");
    dquery("update tblUsers set imeifrequent='" . $services . "' where id='" . $_SESSION["uid"] . "'");
}

?>