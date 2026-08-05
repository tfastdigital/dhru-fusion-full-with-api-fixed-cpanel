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
if (!$server_check) {
    echo "error:" . $LNG["selectanyservice"];
} else {
    dquery("UPDATE  tbl_server_group SET active='0' WHERE group_id='" . $groups . "'");
    if ($grp) {
        foreach ($grp as $ids) {
            $data["active"] = 1;
            $db->update("tbl_server_group", $data, "group_name='" . $ids . "'");
            $data = NULL;
        }
    }
    dquery("UPDATE  `tbl_server_log` SET `active`='0' WHERE group_id='" . $groups . "'");
    if ($server_check) {
        foreach ($server_check as $ids) {
            $data["active"] = 1;
            $data["purchase_cost"] = $purchase_cost[$ids];
            $data["credit"] = $servicecredit[$ids];
            $data["time"] = $times[$ids];
            $data["service_name"] = $servicename[$ids];
            $db->update("tbl_server_log", $data, "id='" . $ids . "'");
            $data = NULL;
            $sql = dquery("SELECT `id`,`code` from `tbl_currencies` where `default`='0'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $d = dquery("SELECT `credit` FROM `tbl_server_credit` WHERE `service_id`='" . $ids . "' AND `currency_id`='" . $row["id"] . "'");
                if (mysqli_num_rows($d)) {
                    $cid = mysqli_fetch_assoc($d);
                    $data["credit"] = ${$row["code"]}[$ids];
                    $data["service_id"] = $ids;
                    $data["currency_id"] = $row["id"];
                    $db->update("tbl_server_credit", $data, "service_id='" . $ids . "' AND currency_id='" . $row["id"] . "'");
                    $data = NULL;
                } else {
                    $data["credit"] = ${$row["code"]}[$ids];
                    $data["service_id"] = $ids;
                    $data["currency_id"] = $row["id"];
                    $db->insert("tbl_server_credit", $data);
                    $data = NULL;
                }
            }
        }
    }
    echo "success:" . $LNG["datasavesuccessfully"];
}
unset($grp);
unset($server_check);

?>