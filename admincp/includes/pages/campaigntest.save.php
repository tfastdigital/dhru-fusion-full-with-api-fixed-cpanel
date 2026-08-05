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
if ($campid && $testemail) {
    $cont = mysqli_fetch_assoc(dquery("select * from tbl_campaign where id='" . $campid . "'"));
    include ROOTDIR . "/includes/mail.fun.php";
    $toemail[] = ["to" => $testemail];
    sendMail("7878787", "", "", "", "", "", "", "", $toemail, base64_decode($cont["message"]), "", $cont["subject"]);
    echo "success: Mail send successfully";
} else {
    echo "error: Email address required";
}

?>