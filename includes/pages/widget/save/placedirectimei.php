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
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
installclient($pagetitle, $pageicon, $breadcrumbnav);
global $token;
$check = generate_token("plain");
if ($token != $check) {
    exit;
}
if ($uid) {
    if ($debug) {
        echo "debug:";
    }
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    $det = mysqli_fetch_assoc(dquery("select * from tbl_private_order where CONCAT(MD5(SHA1(uid)))='" . $uid . "'"));
    if ($det["qnt"] == 0) {
        echo "error:" . $lng_languag["orderaldplaced"];
        exit;
    }
    $id = md5($det["sid"]);
    $serviceDetails = getIMEIServices("", md5($det["sid"]));
    if ($error = placeOrderIMEIvalidation($serviceDetails["reqredfield"], false, $alertaccept, $serviceDetails)) {
        echo $error;
        exit;
    }
    if ($det["chargeable"] && ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails))) {
        echo $error;
        exit;
    }
    $client = mysqli_fetch_assoc(dquery("select id from tblUsers where email='" . $det["email"] . "'"));
    if (!$client["id"]) {
        $username = explode("@", $det["email"]);
        $validator["username"][0] = $username[0];
        $validator["email"][0] = $det["email"];
        $validator["currency"][0] = $_SESSION["system_default_currency"]["id"];
        $validator["language"][0] = $config["language"];
        if (!mysqli_num_rows(dquery("select id from tblUsers where email='" . $det["email"] . "'"))) {
            if (addNewUser($validator, true, "", true, "", "", "", "direct")) {
                dquery("update tblUsers set guest=1 order by id desc limit 1");
            }
            $client = mysqli_fetch_assoc(dquery("select id from \n            tblUsers where email='" . $det["email"] . "'"));
        } else {
            echo "error: You are not allowed";
            exit;
        }
    }
    $_ClientsDetails = getClientsDetails($client["id"]);
    $_SESSION["uid"] = $client["id"];
    $_SESSION["directorder"] = 0;
    $_SESSION["unqid"] = $uid;
    if ($error = creditProcessIMEI($_ClientsDetails, $serviceDetails, $det["id"])) {
        $twiker = explode(":", $error);
        if ($twiker[0] == "success") {
            dquery("update tbl_private_order set\n             qnt=qnt-" . $_SESSION["directorder"] . " where \n             CONCAT(MD5(SHA1(uid)))='" . $uid . "'");
        }
        echo $error;
        exit;
    }
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}

?>