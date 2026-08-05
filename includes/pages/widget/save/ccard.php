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
require_once "./comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
if (!isset($_SESSION["uid"])) {
    echo "error: Something Wrong #99821";
    exit;
}
checkCreditCard($cardno, $cardtype, $errornumber, $errortext);
if ($cardname && $endmonth && $endyear && $ccv) {
    if ($errornumber) {
        echo "error:" . $errortext;
        exit;
    }
    $cardname = preg_replace("/[^a-zA-Z\\s]/", "", $cardname);
    $cardno = preg_replace("/[^0-9]/", "", $cardno);
    $ccv = preg_replace("/[^0-9]/", "", $ccv);
    $lastfr = substr($cardno, strlen($cardno) - 4, 4);
    dquery("UPDATE tblUsers \n    SET \n    cardnum= AES_ENCRYPT('" . $cardno . "','" . $ccenckey . "'),\n    cardtype= '" . $cardtype . "',\n    cardname='" . $cardname . "',\n    ccv= AES_ENCRYPT('" . $ccv . "','" . $ccenckey . "'),\n    startdate= AES_ENCRYPT('" . $startmonth . "-" . $startyear . "','" . $ccenckey . "'),\n    expdate= AES_ENCRYPT('" . $endmonth . "-" . $endyear . "','" . $ccenckey . "'),\n    cardlastfour='" . $lastfr . "'\n    \n    WHERE id='" . $_SESSION["uid"] . "'");
    echo "success:" . $lng_languag["save"] . " " . $lng_languag["successfully"];
} else {
    echo "error: Credit Card details are compulsary";
    exit;
}

?>