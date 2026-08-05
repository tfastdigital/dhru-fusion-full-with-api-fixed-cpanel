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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $token;
$check = generate_token("plain");
if ($token != $check) {
    exit;
}
if ($_SESSION["uid"]) {
    if ($debug) {
        echo "debug:";
    }
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    if (!mysqli_num_rows(dquery("select id from tblUsers where id='" . $_SESSION["uid"] . "' and userstatus=0"))) {
        echo "error: Your account is not active";
        exit;
    }
    if (!$qnt) {
        $qnt = 1;
    }
    $serviceDetails = getIMEIServicesNew("", $id, $_SESSION["uid"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $qnt);
    if ($serviceDetails["acceptterms"] && !$accept) {
        echo "error: Click on Agree with Terms of Services";
        exit;
    }
    $serviceDetails["reqredfield"]["customimeiname"] = $serviceDetails["imei_custom_name"];
    if ($forreward) {
        if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true, $alertaccept, $serviceDetails, 1)) {
            echo $error;
            exit;
        }
    } else {
        if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], true, $alertaccept, $serviceDetails)) {
            echo $error;
            exit;
        }
    }
    if ($forreward) {
        if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails, "", 1)) {
            echo $error;
            exit;
        }
    } else {
        if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails)) {
            echo $error;
            exit;
        }
    }
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}

?>