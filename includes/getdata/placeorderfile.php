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
require_once "../../comm.php";
require_once "../fun.inc.php";
require_once "../client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $token;
$check = generate_token("plain");
if ($token != $check) {
    exit;
}
if ($_SESSION["uid"]) {
    if (!mysqli_num_rows(dquery("select id from tblUsers\n    where id='" . $_SESSION["uid"] . "' and userstatus=0"))) {
        echo "error: Your account is not active";
        exit;
    }
    if ($_SESSION["uid"]) {
        require_once ROOTDIR . "/includes/fileservices.fun.php";
        $serviceDetails = getFileServices("", $id, $_SESSION["uid"], true);
        global $erroring;
        if (!placeOrderFilevalidation($serviceDetails)) {
            echo "error: " . $tempalte_ver["notification"]["error"];
            exit;
        }
        if ($error = creditProcessFile($serviceDetails)) {
            echo "error: " . $error;
            exit;
        }
        echo "success: File Order Placed";
        exit;
    }
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}

?>