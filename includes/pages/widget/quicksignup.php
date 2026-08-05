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
require_once "../comm.php";
require_once ROOTDIR . "/includes/fun.inc.php";
require_once ROOTDIR . "/includes/client.area.inc.php";
require_once ROOTDIR . "/includes/clients.fun.inc.php";
if (md5($_SESSION["gtoken"]) != $gtoken) {
    echo "error: Something Wrong #3892";
    exit;
}
if ($email) {
    global $lng_languag;
    global $email;
    global $first_name;
    global $last_name;
}
global $email;
$validator["email"] = [$email, true];
$u = explode("@", $email);
$validator["username"] = [$u[0], true];
if ($error = validateProfiles($validator)) {
    echo "error: " . $error;
    exit;
}
if ($error = addNewUser($validator, true, "", true)) {
    echo "error: " . $error;
    exit;
}
echo "success: " . "Check Your email <br/> we have sent an email to " . $email . "<br/> Click the link in the email to reset your password. <br/> If you don't see the email, check other places it might be, like your junk, spam, social or other folders.";
exit;

?>