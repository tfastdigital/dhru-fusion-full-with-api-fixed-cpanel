<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

checkDemoMode();
if (!isset($_SESSION[adminid])) {
    exit;
}
require_once ROOTDIR . "/includes/mail.fun.php";
echo sendSMS($mobile, $templateid, $text);

?>