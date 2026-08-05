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
require "../../comm.php";
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $token;
$check = generate_token("plain");
if ($token != $check) {
    exit;
}
if ($_SESSION["uid"]) {
    require_once ROOTDIR . "/includes/serverservices.fun.php";
    if (!mysqli_num_rows(dquery("select id from tblUsers\r\n    where id='" . $_SESSION["uid"] . "' and userstatus=0"))) {
        echo "error: Your account is not active";
        exit;
    }
    $serviceDetails = getServerServices("", $id, $_SESSION["uid"], true);
    if ($error = checkCustomFields($customfield)) {
        echo "error:" . $error;
        exit;
    }
    if ($error = creditProcessServer($_ClientsDetails, $serviceDetails)) {
        echo $error;
        exit;
    }
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}

?>