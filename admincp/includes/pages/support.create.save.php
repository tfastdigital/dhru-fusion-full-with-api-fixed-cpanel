<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
include_once ROOTDIR . "/includes/support.fun.php";
if ($client && $subject && $message) {
    $client = trim($client);
    $client = mysqli_fetch_assoc(dquery("select id from tblUsers\n    where username='" . $client . "'"));
    $ticket["subject"] = $subject;
    $ticket["message"] = $message;
    ticket("", $client["id"], $_SESSION["adminid"], "", "", $department, "", $ticket);
    echo "success:  " . $LNG["savesuccessfully"] . " ";
} else {
    echo "error: " . $LNG["field"] . " " . $LNG["required"] . " ";
}

?>