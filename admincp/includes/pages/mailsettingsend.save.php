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
$data["value"] = trim($SENDMAIL_newusersignup);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_newusersignup'");
$data = NULL;
$data["value"] = trim($SENDMAIL_passwordresetlink);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_passwordresetlink'");
$data = NULL;
$data["value"] = trim($SENDMAIL_userpasswordchangeconfirm);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_userpasswordchangeconfirm'");
$data = NULL;
$data["value"] = trim($SENDMAIL_ordercanceledbyuser);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_ordercanceledbyuser'");
$data = NULL;
$data["value"] = trim($SENDMAIL_securityquestionchangeconfirm);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_securityquestionchangeconfirm'");
$data = NULL;
$data["value"] = trim($SENDMAIL_welcomemail);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_welcomemail'");
$data = NULL;
$data["value"] = trim($SENDMAIL_newordernotificationtoreseller);
$db->update("tbl_configer", $data, "attribute='SENDMAIL_newordernotificationtoreseller'");
$data = NULL;
echo "success:" . $LNG["datasavesuccessfully"];

?>