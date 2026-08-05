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
foreach ($list as $key => $value) {
    $admin_id = mysqli_fetch_assoc(dquery("select admin_id from tbl_recent_menu where admin_id=" . $_SESSION["adminid"] . " and page_id=" . $key));
    if ($admin_id[0]) {
        if ($value) {
            dquery("update tbl_recent_menu set listing='" . $value . "' where page_id=" . $key . " and admin_id=" . $_SESSION["adminid"]);
        } else {
            dquery("delete from tbl_recent_menu where page_id=" . $key . " and admin_id=" . $_SESSION["adminid"]);
        }
    } else {
        if ($value) {
            dquery("insert into tbl_recent_menu (page_id,listing,admin_id) value ('" . $key . "','" . $value . "'," . $_SESSION["adminid"] . ")");
        }
    }
}
echo "success:" . $LNG["update"] . " " . $LNG["successfully"];

?>