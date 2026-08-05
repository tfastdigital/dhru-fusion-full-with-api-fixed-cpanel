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
    $values = md5(md5($NEWPASS) . "9486");
    dquery("UPDATE tblUsers set password='" . $values . "' WHERE username='" . $search . "'");
    $reply["STATUS"] = "SUCCESS";
    $reply["DATA"] = $NEWPASS;
    if ($config["SENDMAIL_userpasswordchangeconfirm"]) {
        $row = mysqli_fetch_assoc(dquery("select username,id from tblUsers where username='" . $search . "'"));
        require ROOTDIR . "/includes/mail.fun.php";
        $email_merge_fields["username"] = $row["username"];
        sendMail(4, $row["id"], "", $email_merge_fields);
    }
} else {
    $reply["STATUS"] = "ERROR";
}
$reply["VERSION"] = $api_version;
echo json_encode($reply);
function genRandomString()
{
    $length = 5;
    $characters = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    $string = "";
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}

?>