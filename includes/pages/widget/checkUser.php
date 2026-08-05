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
global $lng_languag;
global $_ClientsDetails;
if ($checkpassword) {
    $return = pwd_valid($password);
    echo $return;
} else {
    $user = descape(trim($_GET["username"]));
    $user = preg_replace("/[^A-Za-z0-9]/", "", $user);
    $bannedusername = ["admin", "administrator", "user"];
    $flag = false;
    if (in_array(strtolower($user), $bannedusername, true)) {
        $flag = true;
    }
    if ($user != $_ClientsDetails["username"] && $user != "") {
        $sql = mysqli_num_rows(dquery("SELECT `id` FROM `tblUsers` WHERE `username`='" . $user . "'"));
        if ($sql || $flag) {
            echo "error: " . $user . " " . $lng_languag["notavailable"];
        } else {
            echo "success: " . $user . " " . $lng_languag["available"];
        }
    }
}

?>