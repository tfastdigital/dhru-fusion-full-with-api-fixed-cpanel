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
$where = "userstatus!=1";
$reason = "";
if ($lastlogin) {
    $time = time() - 2592000;
    $lastlogin = strtotime($lastlogin);
    $where .= " and cast(last_login as signed)<" . $lastlogin . " and cast(ac_create_dt as signed)<" . $time;
}
if ($credit != "") {
    $where .= " and credit_left<=" . $credit;
}
if ($neverfund) {
    $where .= " and (select count(id) from tbl_statement_user where uid=tblUsers.id limit 1)=0";
}
if ($unverified) {
    $where .= " and userstatus='2'";
}
if ($lastlogin || $credit != "" || $unverified || $neverfund) {
    dquery("UPDATE tblUsers set userstatus=1,block_reason='" . $reason . "' where  " . $where);
}
echo "success:" . $LNG["datasavesuccessfully"];

?>