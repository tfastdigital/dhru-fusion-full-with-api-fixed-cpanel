<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$search = preg_replace("/[^0-9a-zA-Z]/i", "", $_POST["search"]);
$NEWPASS = genRandomString();
if ($NEWPASS != "") {
    require ROOTDIR . "/includes/mail.fun.php";
    $mailmerge["masterpin"] = $NEWPASS;
    $NEWPASS = enc((string) $NEWPASS, "9486");
    dquery("UPDATE tblUsers SET master_pin='" . $NEWPASS . "' WHERE username='" . $search . "'");
    $cid = mysqli_fetch_assoc(dquery("select id from tblUsers where username='" . $search . "'"));
    sendMail("56", $cid["id"], "", $mailmerge, true);
    $reply["STATUS"] = "SUCCESS";
} else {
    $reply["STATUS"] = "ERROR";
}
$reply["VERSION"] = $api_version;
echo json_encode($reply);
function genRandomString()
{
    $length = 4;
    $characters = "123456789";
    $string = "";
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

?>