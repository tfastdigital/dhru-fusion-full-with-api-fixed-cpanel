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
$data["active"] = $status;
$data["service_name"] = $servicename;
$data["group_id"] = $groupname;
$data["time"] = $time1 . " " . $timeref;
$row = mysqli_fetch_assoc(dquery("select credit from tbl_server_log where id=" . $id));
if ($row["credit"] != $credit) {
    $success = $LNG["credit"] . " " . $LNG["changed"] . " " . $LNG["resetdiscount"];
}
$data["verifiable"] = $verification;
$data["smsnotification"] = $smsnotification;
$data["usercan_cancel"] = $cancel;
$data["icon_link"] = $iconlink;
$data["download_link"] = $downloadlink;
$data["faq_id"] = $faq;
$data["notification_mail"] = $notificationmail;
$data["template_id1"] = $template1;
$data["template_id2"] = $template2;
$data["notificationemail"] = $notificationemail;
if ($db->update("tbl_server_log", $data, "id=" . $id)) {
    echo "success:<li>" . $LNG["datasavesuccessfully"] . "</li><li>" . $success . "</li>";
} else {
    echo "error:" . $LNG["datanotsave"];
}
echo " ";

?>