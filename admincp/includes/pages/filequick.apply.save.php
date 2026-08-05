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
if (!$file_check) {
    echo "error:" . $LNG["selectanyservice"];
} else {
    foreach ($file_check as $ids) {
        if ($quickapply == 15) {
            if ($removetype == 1) {
                dquery("UPDATE tbl_services_file set active='2' where id='" . $ids . "'");
            } else {
                dquery("DELETE FROM tbl_services_file WHERE id='" . $ids . "'");
                dquery("DELETE FROM tbl_file_credit WHERE service_id='" . $ids . "'");
                if ($remorder) {
                    dquery("DELETE FROM tbl_order_file WHERE service_id='" . $ids . "'");
                }
                if ($remclient) {
                    dquery("DELETE FROM tbl_client_group_price WHERE service_id='" . $ids . "' \n                    AND service_type='file'");
                }
                dquery("DELETE FROM tbl_discount_file WHERE service_id='" . $ids . "'");
            }
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($file_check);
echo " ";

?>